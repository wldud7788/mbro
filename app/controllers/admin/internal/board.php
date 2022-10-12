<?php
/**
 * Internal API for Admin Board
 *
 * 게시판 설정에서 내부적으로 사용되는 API를 정의합니다.
 * 
 * Copyright (C) Gabia C&S Inc. All Rights Reserved.
 *
 * @category   Admin
 * @package    Firstmall
 * @author     Keunhwan Kim <kgh@gabiacns.com>
 * @copyright  2020 Gabia C&S
 */
declare(strict_types=1);

if ( !defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/base/admin_base".EXT);

use App\Libraries\Http\Request;
use App\Libraries\Http\JsonResponse as Response;
use App\Errors\AuthenticateRequiredException;
use App\Errors\NotFoundException;

class board extends admin_base {
    private $board_id = null;
    protected function get_board_config_fields() {
        return [
            'id' => [
                'default' => '',
            ],
            'name' => [
                'default' => '',
            ],
            'references' => [
                'dbfield' => false,
                'default' => new stdClass,
            ],
            'skin' => [
                'dbfield' => 'skin',
                'default' => 'gallery',
                'type' => 'enum',
                'values' => [
                    'gallery01' => 'gallery',
                    'default01' => 'list',
                    'gallery02' => 'thumbnail',
                ],
            ],
            'reply.use' => [
                'dbfield' => 'auth_reply_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'comment.use' => [
                'dbfield' => 'auth_cmt_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'recommend.comment.use' => [
                'dbfield' => 'auth_cmt_recommend_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'recommend.comment.type' => [
                'dbfield' => 'cmt_recommend_type',
                'default' => 'upanddown',
                'type' => 'enum',
                'values' => [
                    1 => 'up',
                    2 => 'upanddown',
                ],
            ],
            'recommend.article.use' => [
                'dbfield' => 'auth_recommend_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'recommend.article.type' => [
                'dbfield' => 'recommend_type',
                'default' => 'upanddown',
                'type' => 'enum',
                'values' => [
                    1 => 'up',
                    2 => 'upanddown',
                    3 => '5grades',
                ],
            ],
            'recommend.article.icon.__recommend' => [
                'dbfield' => 'recommend',
                'visible' => false,
            ],
            'recommend.article.icon.__none_rec' => [
                'dbfield' => 'none_rec',
                'visible' => false,
            ],
            'recommend.article.icon.__recommend1' => [
                'dbfield' => 'recommend1',
                'visible' => false,
            ],
            'recommend.article.icon.__recommend2' => [
                'dbfield' => 'recommend2',
                'visible' => false,
            ],
            'recommend.article.icon.__recommend3' => [
                'dbfield' => 'recommend3',
                'visible' => false,
            ],
            'recommend.article.icon.__recommend4' => [
                'dbfield' => 'recommend4',
                'visible' => false,
            ],
            'recommend.article.icon.__recommend5' => [
                'dbfield' => 'recommend5',
                'visible' => false,
            ],
            'recommend.article.icon' => [
                'dbfield' => false,
                'setter' => function(&$data) {
                    foreach([
                        'recommend',
                        'none_rec',
                        'recommend1',
                        'recommend2',
                        'recommend3',
                        'recommend4',
                        'recommend5',
                    ] as $field) {
                        $data->{"recommend.article.icon.__{$field}"} = $data->{'recommend.article.icon'}->{$field};
                    }
                },
                'getter' => function($board_config) { return (object)array_reduce([
                    'recommend',
                    'none_rec',
                    'recommend1',
                    'recommend2',
                    'recommend3',
                    'recommend4',
                    'recommend5',
                ], function($carry, $field) { $carry[$field] = $board_config->{"recommend.article.icon.__{$field}"}?:"/admin/skin/default/images/board/icon/icon_{$field}.png"; return $carry; }, []); },
            ],
            'recommend.comment.icon.__recommend' => [
                'dbfield' => 'recommend',
                'visible' => false,
            ],
            'recommend.comment.icon.__none_rec' => [
                'dbfield' => 'none_rec',
                'visible' => false,
            ],
            'recommend.comment.icon' => [
                'dbfield' => false,
                'setter' => function(&$data) {
                    foreach([
                        'recommend',
                        'none_rec',
                    ] as $field) {
                        $data->{"recommend.comment.icon.__{$field}"} = $data->{'recommend.comment.icon'}->{$field};
                    }
                },
                'getter' => function($board_config) { return (object)array_reduce([
                    'recommend',
                    'none_rec',
                ], function($carry, $field) { $carry[$field] = $board_config->{"recommend.comment.icon.__{$field}"}?:"/admin/skin/default/images/board/icon/icon_cmt_{$field}.png"; return $carry; }, []); },
            ],
            'article.default.use' => [
                'dbfield' => false,
                'default' => false,
                'getter' => function($board_config) { return !empty($board_config->{'article.default.text'}); },
                'type' => 'boolean',
            ],
            'article.default.text' => [
                'dbfield' => 'content_default',
            ],
            'article.captcha.use' => [
                'dbfield' => 'autowrite_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'article.private.__raw' => [
                'visible' => false,
                'dbfield' => 'secret_use',
                'default' => 'N',
                'type' => 'string',
            ],
            'article.private.use' => [
                'dbfield' => false,
                'default' => false,
                'getter' => function($board_config) { return $board_config->{'article.private.__raw'} !== 'N'; },
                'setter' => function(&$data) { $data->{'article.private.__raw'} = 'N'; },
                'type' => 'boolean',
            ],
            'article.private.only' => [
                'dbfield' => false,
                'default' => false,
                'getter' => function($board_config) { return $board_config->{'article.private.__raw'} === 'A'; },
                'setter' => function(&$data) { $data->{'article.private.__raw'} = 'A'; },
                'type' => 'boolean',
            ],
            'article.attachment.use' => [
                'dbfield' => 'file_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'article.attachment.imageonly' => [
                'dbfield' => 'onlyimage_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'article.video.use' => [
                'dbfield' => 'video_use',
                'default' => false,
                'type' => 'boolean',
            ],
            'article.video.encoding.quality' => [
                'dbfield' => 'video_type',
                'default' => 400,
                'type' => 'integer'
            ],
            'article.video.encoding.__size' => [
                'visible' => false,
                'dbfield' => 'video_screen',
                'default' => '400X300',
            ],
            'article.video.encoding.size.width' => [
                'dbfield' => false,
                'default' => 400,
                'getter' => function($board_config) { return @(+$board_config->{'article.video.encoding.__size'}); },
                'setter' => function(&$data) { $data->{'article.video.encoding.__size'} = preg_replace('/^\d+(?=X)/', $data->{'article.video.encoding.size.width'}, $data->{'article.video.encoding.__size'}); },
                'type' => 'integer'
            ],
            'article.video.encoding.size.height' => [
                'dbfield' => false,
                'default' => 300,
                'getter' => function($board_config) { return @(+preg_replace('/^\d+X/i', '', $board_config->{'article.video.encoding.__size'})); },
                'setter' => function(&$data) { $data->{'article.video.encoding.__size'} = preg_replace('/(?<=X)\d+$/', $data->{'article.video.encoding.size.height'}, $data->{'article.video.encoding.__size'}); },
                'type' => 'integer'
            ],
            'article.video.display.__size' => [
                'visible' => false,
                'dbfield' => 'video_size',
                'default' => '400X300',
            ],
            'article.video.display.mobile.__size' => [
                'visible' => false,
                'dbfield' => 'video_size_mobile',
                'default' => '200X150',
            ],
            'article.video.display.size.width' => [
                'dbfield' => false,
                'default' => 400,
                'getter' => function($board_config) { return @(+$board_config->{'article.video.display.__size'}); },
                'setter' => function(&$data) { $data->{'article.video.display.__size'} = preg_replace('/^\d+(?=X)/', $data->{'article.video.display.size.width'}, $data->{'article.video.display.__size'}); },
                'type' => 'integer'
            ],
            'article.video.display.size.height' => [
                'dbfield' => false,
                'default' => 300,
                'getter' => function($board_config) { return @(+preg_replace('/^\d+X/i', '', $board_config->{'article.video.display.__size'})); },
                'setter' => function(&$data) { $data->{'article.video.display.__size'} = preg_replace('/(?<=X)\d+$/', $data->{'article.video.display.size.height'}, $data->{'article.video.display.__size'}); },
                'type' => 'integer'
            ],
            'article.video.display.size.mobile.width' => [
                'dbfield' => false,
                'default' => 200,
                'getter' => function($board_config) { return @(+$board_config->{'article.video.display.mobile.__size'}); },
                'setter' => function(&$data) { $data->{'article.video.display.mobile.__size'} = preg_replace('/^\d+(?=X)/', $data->{'article.video.display.size.mobile.width'}, $data->{'article.video.display.mobile.__size'}); },
                'type' => 'integer'
            ],
            'article.video.display.size.mobile.height' => [
                'dbfield' => false,
                'default' => 150,
                'getter' => function($board_config) { return @(+preg_replace('/^\d+X/i', '', $board_config->{'article.video.display.mobile.__size'})); },
                'setter' => function(&$data) { $data->{'article.video.display.mobile.__size'} = preg_replace('/(?<=X)\d+$/', $data->{'article.video.display.size.mobile.height'}, $data->{'article.video.display.mobile.__size'}); },
                'type' => 'integer'
            ],
            'by_line.type' => [
                'dbfield' => 'write_show',
                'default' => 'id-grade',
                'type' => 'enum',
                'values' => [
                    'ID' => 'id-grade',
                    'ID-NONE' => 'id',
                    'NAME' => 'name-grade',
                    'NAME-NONE' => 'name',
                    'NIC' => 'nickname-grade',
                    'NIC-NONE' => 'nickname',
                    'ID-NAME' => 'name-id-grade',
                    'ID-NAME-NONE' => 'name-id',
                    'ID-NIC' => 'nickname-id-grade',
                    'ID-NIC-NONE' => 'nickname-id',
                ],
            ],
            'by_line.mask.use' => [
                'dbfield' => 'show_name_type',
                'default' => true,
                'type' => 'enum',
                'values' => [
                    'ALL' => false,
                    'HID' => true,
                ],
            ],
            'by_line.grade.type' => [
                'dbfield' => 'show_grade_type',
                'default' => 'text',
                'type' => 'enum',
                'values' => [
                    'TXT' => 'text',
                    'IMG' => 'image',
                ],
            ],
            'by_line.visible.__writer_date' => [
                'visible' => false,
                'dbfield' => 'writer_date',
                'default' => 'none',
            ],
            'by_line.visible.registered_at' => [
                'dbfield' => false,
                'default' => true,
                'getter' => function($board_config) { return in_array($board_config->{'by_line.visible.__writer_date'}, ['all', 'regit']); },
                'setter' => function(&$data) { if(!$data->{'by_line.visible.registered_at'}) return; $data->{'by_line.visible.__writer_date'} = $data->{'by_line.visible.__writer_date'}?'all':'regit'; },
                'type' => 'boolean',
            ],
            'by_line.visible.visited_at' => [
                'dbfield' => false,
                'default' => true,
                'getter' => function($board_config) { return in_array($board_config->{'by_line.visible.__writer_date'}, ['all', 'login']); },
                'setter' => function(&$data) { if(!$data->{'by_line.visible.visited_at'}) return; $data->{'by_line.visible.__writer_date'} = $data->{'by_line.visible.__writer_date'}?'all':'login'; },
                'type' => 'boolean',
            ],
            'admin.type' => [
                'dbfield' => 'write_admin_type',
                'default' => 'text',
                'type' => 'enum',
                'values' => [
                    'TXT' => 'text',
                    'IMG' => 'image',
                ],
            ],
            'admin.display.text' => [
                'dbfield' => 'write_admin',
                'default' => '관리자',
            ],
            'admin.display.image' => [
                'dbfield' => 'icon_admin_img',
                'default' => '/admin/skin/default/images/board/icon/icon_admin.gif',
            ],
            'admin.visible.created_at' => [
                'dbfield' => 'admin_regist_view',
                'default' => false,
                'type' => 'boolean',
            ],
            '__acl.article.read' => [
                'visible' => false,
                'dbfield' => 'auth_read',
                'default' => '[all]',
            ],
            '__acl.article.write' => [
                'visible' => false,
                'dbfield' => 'auth_write',
                'default' => '[all]',
            ],
            '__acl.reply.write' => [
                'visible' => false,
                'dbfield' => 'auth_reply',
                'default' => '[all]',
            ],
            '__acl.comment.write' => [
                'visible' => false,
                'dbfield' => 'auth_cmt',
                'default' => '[all]',
            ],
            'acl' => [
                'dbfield' => false,
                'setter' => function(&$data) {
                    /** Group ACL */
                    $entity_acl = [
                        'article.read' => [],
                        'article.write' => [],
                        'reply.write' => [],
                        'comment.write' => [],
                    ];
                    foreach($data->acl->group as $group_id => $entities) {
                        foreach($entities as $entity => $use) {
                            if($use) {
                                if(is_numeric($group_id)) {
                                    $group_id = "group:{$group_id}";
                                    $entity_acl[$entity]['member'] = true;
                                }
                                $entity_acl[$entity][$group_id] = true;
                            }
                        }
                    }
                    foreach($entity_acl as $entity => $groups) {
                        $data->{"__acl.{$entity}"} = '['.implode('][', array_keys($groups)).']';
                    }

                    /** User ACL */
                    $this->load->model('managermodel');
                    $this->load->model('boardadmin');
                    foreach($data->acl->user as $user_id => $entities) {
                        $user = $this->managermodel->find($user_id);
                        if(null === $user) throw new NotFoundException("관계 오류: 관리자 `{$user_id}`를 찾을 수 없습니다.");
                        if(!isset($this->managerInfo['manager_seq'])) throw new AuthenticateRequiredException;
                        $db_boardadmin = $this->boardadmin->get_query_builder();
                        $result = $this->boardadmin
                            ->update([
                                'boardid' => $this->board_id,
                                'manager_seq' => $user->manager_seq,
                                'board_view' => $entities->{'article.read'} ? $entities->{'article.private'} ? '2' : '1' : '0',
                                'board_act' => $entities->{'admin'}?'1':'0',
                                'r_manager_seq' => $this->managerInfo['manager_seq'],
                            ]);
                    }
                },
                'getter' => function($board_config) {
                    $acl = (object)[
                        'group' => new stdClass,
                        'user' => new stdClass,
                    ];
                    $board_config->references->users = new stdClass;
                    $board_config->references->groups = (clone $this->db)->reset_query()->select('group_seq id, group_name name')->from('fm_member_group')->get()->result();

                    /** Group ACL */
                    foreach(['article.read','article.write','reply.write','comment.write'] as $entity) {
                        if(!preg_match_all('/\[(.*?)\]/', $board_config->{"__acl.{$entity}"}, $groups)) continue;
                        foreach($groups[1] as $group_raw_id) {
                            @list($group_id, $group_seq) = explode(':', $group_raw_id, 2);
                            switch($group_id) {
                                case 'admin':
                                    $group_id = 'admin';
                                    break;
                                case 'member':
                                    $group_id = null;
                                    continue;
                                case 'group':
                                    $group_id = $group_seq;
                                    break;
                            }
                            if(empty($group_id)) continue;
                            if(!isset($acl->group->{$group_id})) $acl->group->{$group_id} = new stdClass;
                            $acl->group->{$group_id}->$entity = true;
                        }
                    }

                    /** User ACL */
                    $this->load->model('managermodel');
                    $member_acl = $this->managermodel->get_query_builder()
                        ->select('`fm_manager`.*, `fm_boardadmin`.*, (SELECT `value` = "Y" FROM `fm_manager_auth` WHERE `fm_manager_auth`.`manager_seq` = `fm_manager`.`manager_seq` AND `fm_manager_auth`.`shopSno` = '.$this->db->escape($this->config_system['shopSno']).' AND `fm_manager_auth`.`codecd` = "manager_yn" LIMIT 1) AS `manager_yn`', false)
                        ->join('fm_boardadmin', 'fm_boardadmin.manager_seq = fm_manager.manager_seq AND fm_boardadmin.boardid = '.$this->db->escape($board_config->id), 'left')
                        ->get()->result();
                    foreach($member_acl as $row) {
                        if(!isset($acl->user->{$row->manager_id})) $acl->user->{$row->manager_id} = new stdClass;
                        $acl->user->{$row->manager_id}->{'article.read'} = $row->board_view===null?!!$row->manager_yn:!!$row->board_view;
                        $acl->user->{$row->manager_id}->{'article.private'} = $row->board_view===null?!!$row->manager_yn:$row->board_view === '2';
                        $acl->user->{$row->manager_id}->{'admin'} = $row->board_act===null?!!$row->manager_yn:!!$row->board_act;
                        $board_config->references->users->{$row->manager_id} = (object)[
                            'id' => $row->manager_id,
                            'name' => $row->mname,
                            'is_manager' => !!$row->manager_yn,
                        ];
                    }
                    return $acl;
                },
            ],
            'list.limit' => [
                'dbfield' => 'pagenum',
                'default' => 20,
                'type' => 'integer'
            ],
            'list.image.size.width' => [
                'dbfield' => 'gallery_list_w',
                'default' => 250,
                'type' => 'integer'
            ],
            'list.image.size.height' => [
                'dbfield' => 'gallery_list_h',
                'default' => 250,
                'type' => 'integer'
            ],
            'list.column' => [
                'dbfield' => 'list_show',
                'default' => [
                    'no',
                    'subject',
                    'author',
                    'created_at',
                    'views',
                    'recommends',
                ],
                'getter' => function($board_config) {
                    if($board_config->{'list.column'} === null) throw new \OutOfBoundsException;
                    preg_match_all('/\[(.*?)\]/', $board_config->{'list.column'}, $matches, PREG_PATTERN_ORDER);
                    return array_map(function($value) {
                        return [
                            'num' => 'no',
                            'subject' => 'subject',
                            'writer' => 'author',
                            'date' => 'created_at',
                            'hit' => 'views',
                            'score' => 'recommends',
                        ][$value];
                    }, $matches[1]);
                },
                'setter' => function(&$data) {
                    $data->{'list.column'} = '['.implode('][', array_map(function($value) {
                        return [
                            'no' => 'num',
                            'subject' => 'subject',
                            'author' => 'writer',
                            'created_at' => 'date',
                            'views' => 'hit',
                            'recommends' => 'score',
                        ][$value];
                    }, $data->{'list.column'})).']';
                },
            ],
            'list.trim.subject' => [
                'dbfield' => 'subjectcut',
                'default' => 30,
                'type' => 'integer'
            ],
            'list.icon.__new' => [
                'dbfield' => 'new',
                'visible' => false,
            ],
            'list.icon.__hot' => [
                'dbfield' => 'hot',
                'visible' => false,
            ],
            'list.icon' => [
                'dbfield' => false,
                'setter' => function(&$data) {
                    foreach([
                        'new',
                        'hot',
                    ] as $field) {
                        $data->{"list.icon.__{$field}"} = $data->{'list.icon'}->{$field};
                    }
                },
                'getter' => function($board_config) { return (object)array_reduce([
                    'new',
                    'hot',
                ], function($carry, $field) { $carry[$field] = $board_config->{"list.icon.__{$field}"}?:"/admin/skin/default/images/board/icon/icon_{$field}.gif"; return $carry; }, []); },
            ],
            'list.criteria.new' => [
                'dbfield' => 'icon_new_day',
                'type' => 'integer',
                'default' => 1,
            ],
            'list.criteria.hot' => [
                'dbfield' => 'icon_hot_visit',
                'type' => 'integer',
                'default' => 30,
            ],
            'category' => [
                'dbfield' => 'category',
                'default' => [],
                'getter' => function($board_config) { return $board_config->category !== null?explode(',', $board_config->category):[]; },
                'setter' => function(&$data) {
                    $data->{'category'} = implode(',', $data->{'category'});
                },
            ],
            'sms' => [
                'dbfield' => false,
                'getter' => function($board_config) {
                    $id_length = strlen($board_config->id);
                    $sms_config = array_reduce(config_search('sms', $board_config->id), function($result, $item) use ($id_length) {
                        $result->{substr($item->codecd, $id_length+1)} = $item->value;
                        return $result;
                    }, new stdClass);
                    var_dump($sms_config);
                    exit;
                },
            ],
        ];
    }

    public function __construct() {
        try {
            parent::__construct([
                'useException' => true,
            ]);
        } catch (AuthenticateRequiredException $ex) {
            Response::error($ex, 401);
        } catch (Exception $ex) {
            Response::error($ex);
        }

        $this->load->model('Boardmodel');
        $this->load->model('Boardmanager');
    }

    protected function get_db_row_from_data($data) {
        $board_config_info = $this->get_board_config_fields() or Response::error(new ArgumentCountError);
        $db_data = [];

        foreach($data as $name => $value) {
            if(is_callable($board_config_info[$name]['setter'])) {
                $board_config_info[$name]['setter']($data);
            }
        }

        foreach($data as $name => $value) {
            if(false === $board_config_info[$name]['dbfield']) continue;
            $db_value = $value;
            if(!isset($board_config_info[$name]['dbfield'])) {
                $board_config_info[$name]['dbfield'] = $name;
            }
            switch($board_config_info[$name]['type']) {
                case 'enum':
                    $db_value = array_search($value, $board_config_info[$name]['values']);
                break;
                default:
            }
            if(is_string($board_config_info[$name]['dbfield'])) {
                $db_data[$board_config_info[$name]['dbfield']] = $db_value;
            }
        }
        return $db_data;
    }

    protected function _put() {
        $this->load->model('Boardmanager');

        $data = Request::json();
        if(count($data) === 0) Response::ok();
        $db_data = $this->get_db_row_from_data($data);
        if(count($db_data) === 0) Response::error(new LogicException('변경사항이 처리되지 않았습니다. 알 수 없는 오류가 발생했습니다.'), 400);

        $this->Boardmanager->insert($db_data);
        return Response::ok();
    }

    protected function _patch($board_id = null) {
        $this->board_id = $board_id;
        $this->load->model('Boardmanager');

        $data = Request::json();
        if(count($data) === 0) Response::ok();
        $db_data = $this->get_db_row_from_data($data);
        if(count($db_data) === 0) Response::error(new LogicException('변경사항이 처리되지 않았습니다. 알 수 없는 오류가 발생했습니다.'), 400);

        $this->Boardmanager->update($db_data, $board_id);
        return Response::ok();
    }

    protected function _get($board_id = null) {
        $this->load->model('Boardmanager');

        $board_config = new stdClass;
        $board_config_info = new stdClass;

        $raw_manager_row = is_null($board_id)?new stdClass:$this->Boardmanager->find($board_id) or Response::error(new NotFoundException('게시판을 찾을 수 없습니다.'), 404);
        $board_config_info = $this->get_board_config_fields() or Response::error(new LogicException);
        foreach($board_config_info as $row => $info) {
            if(!isset($info['dbfield'])) {
                $info['dbfield'] = $row;
            }
            if(isset($info['dbfield']) && $info['dbfield'] !== false && property_exists($raw_manager_row, $info['dbfield'])) {
                if(isset($info['type']) && $info['type'] !== 'string' || !empty($raw_manager_row->{$info['dbfield']})) {
                    $board_config->{$row} = $raw_manager_row->{$info['dbfield']};
                }
            }
            if(isset($info['getter'])) {
                if(is_callable($info['getter'])) {
                    $getter_result = null;
                    try {
                        $getter_result = $info['getter']($board_config);
                        $board_config->{$row} = $getter_result;
                    } catch(Exception $ex) {
                    }
                }
            }
            if(isset($info['type']) && property_exists($board_config, $row)) switch($info['type']) {
                case 'enum':
                    if(!isset($info['values'])) break;
                    if(!isset($info['values'][$board_config->{$row}])) throw new \OutOfBoundsException("Unknown enum value `{$board_config->{$row}}` provided on `{$row}`.");
                    $board_config->{$row} = $info['values'][$board_config->{$row}];
                break;
                case 'boolean':
                case 'bool':
                    if(is_string($board_config->{$row})) switch(strtolower($board_config->{$row})) {
                        case 'y':
                        case '1':
                        case 'on':
                            $board_config->{$row} = true;
                        break;
                        case 'n':
                        case '0':
                        case 'off':
                            $board_config->{$row} = false;
                        break;
                        default:
                            $board_config->{$row} = !!$board_config->{$row};
                        break;
                    }
                    else {
                        $board_config->{$row} = !!$board_config->{$row};
                    }
                break;
                case 'integer':
                case 'int':
                    $board_config->{$row} = +$board_config->{$row};
                break;
                default: break;
            }
            if(isset($info['default']) && !property_exists($board_config, $row)) {
                $board_config->{$row} = $info['default'];
            }
        }

        $board_output = new stdClass;
        foreach($board_config as $row => $value) {
            if(!isset($board_config_info[$row]['visible']) || isset($board_config_info[$row]['visible']) && $board_config_info[$row]['visible'] !== false) {
                $board_output->{$row} = $value;
            }
        }
        return Response::ok($board_output);
    }

    protected function _delete() {
        $data = Request::json();
        if(empty($data->id)) return Response::ok();

        $deleted_board_count = 0;
        $this->db->trans_start();
        foreach($data->id as $id) {
            if($this->Boardmanager->manager_delete($id)) {
                if( $id == 'goods_qna' ) {
                    $this->load->model('Goodsqna','Boardmodel');
                }elseif( $id == 'goods_review' ) {
                    $this->load->model('Goodsreview','Boardmodel');
                }elseif( $id == 'bulkorder' ) {
                    $this->load->model('Boardbulkorder','Boardmodel');
                }else{
                    $this->load->model('Boardmodel');
                }

                $this->load->helper('file_helper');
                $this->load->model('Boardindex');
                $this->load->model('Boardcomment');
                $this->load->model('boardadmin');

                if(
                    !$this->boardadmin->boardadmin_delete_id($id) ||
                    !$this->Boardindex->idx_delete_id($id) ||
                    !$this->Boardmodel->data_delete_id($id) ||
                    !$this->Boardcomment->data_delete_id($id) ||
                    !$this->Boardscorelog->data_delete_id($id) ||
                    !delete_files($this->Boardmanager->board_data_dir.$id.'/', TRUE, 1) ||
                    !delete_files($this->Boardmanager->board_skin_dir.$id.'/', TRUE, 1)
                ) throw new RuntimeException;

                $deleted_board_count++;
            }
        }
        if($deleted_board_count !== count($data->id)) throw new RuntimeException('삭제할 게시판과 삭제된 게시판 수가 맞지 않습니다.');
        $this->db->trans_complete();
    }

    public function index(...$args) {
        if($args[0] === 'dashboard') return $this->dashboard();
        try {
            switch(Request::method()) {
                case 'get': return $this->_get(...$args);
                case 'put': return $this->_put(...$args);
                case 'delete': return $this->_delete(...$args);
                case 'patch': return $this->_patch(...$args);
                default: Response::error(null, 404);
            }
        } catch(Exception $ex) {
            Response::error($ex);
        }
    }

    public function dashboard() {
        try {
            if(Request::method('put')) {
                $data = Request::json();

                $query	= $this->db->query('DELETE FROM `fm_config` WHERE `groupcd` = "board_main"');

                foreach($data as $idx => $board_id) {
                    config_save("board_main" , [$board_id => $idx+1]);
                }

                return Response::ok();
            }
            else {
                return Response::ok(config_load('board_main'));
            }
        } catch (Exception $ex) {
            Response::error($ex);
        }
    }
}

/* End of file internal.php */
/* Location: ./app/controllers/admin/internal.php */
