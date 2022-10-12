// 디스플레이 캐시 on/off 상태 변경
function chgDisplayCachStatus(){
    var now_status	= $("span.display-cach-status").html();
    var chg_status	= '';
    if	(now_status == 'OFF')	chg_status = 'ON';
    else						chg_status = 'OFF';
    $.ajax({
        type: "post",
        url: "../setting_process/set_display_status",
        data: "status="+chg_status,
        success: function(result){
            $("span.display-cach-status").html(chg_status);
            $("button.display-cach-btn").html(now_status);
        }
    });
}
function chgMainCacheErr(){    
    openDialogAlert("<a href='../setting/snsconf' class='highlight-link'>설정 > SNS/외부 연동</a> 메뉴에서 먼저 페이스북 쇼핑몰 설정을 하십시오.", 450, 150);
}
function chgMainCache(platform){     
    $.ajax({
        type: "post",
        dataType : 'json',
        data    : 'platform='+platform,
        url: "../setting_process/createMainCache",			
        success: function(result){
            openDialogAlert("<div class='left'>캐시파일 생성 처리 결과입니다.<br>대상 : 1개<br>성공 : 1개<br>실패 : 0개</div>", 450, 200);
            get_contents();
        }
    });          
}
function setMainCachePrnErr(){    
    openDialogAlert('캐시파일이 존재하지 않습니다. 캐시파일을 생성해 주세요.', 400, 150);        
}
function setMainCachePrn(bobj, platform){
    var obj         = $(bobj);
    var chg_status  = 'n';
    if( obj.hasClass('off') ){
        chg_status  = 'y';
    }
    $.ajax({
        type: "post",
        dataType : 'json',
        data: "mainCachePrn=" + chg_status + '&platform='+ platform,
        url: "../setting_process/setMainCachePrn",			
        success: function(result){            
            if(result.code == '20' && result.sMainCachePrn == 'y'){                
                openDialogAlert("<div class='left'>해당 메인페이지의 캐시파일이 사용으로 설정되었습니다.<br>앞으로 해당 메인페이지의 캐시파일을 최신으로 관리해 주십시오.<br>단, 페이지에 속한 상품디스플레이는 해당 상품디스플레이 캐시 사용여부를 따르게 됩니다.</div>", 550, 200);
            }else if(result.code == '20'){                
                openDialogAlert("해당 메인페이지의 캐시파일이 미사용으로 설정되었습니다", 550, 150);
            }            
            get_contents();
        }
    });
}
function viewMainCache(bobj, platform){
    var obj         = $(bobj);
    if( obj.hasClass('disabled') ){
        openDialogAlert('캐시파일이 존재하지 않습니다. 캐시파일을 생성해 주세요.', 400, 150);
        return false;
    }
    if(platform == 'pc' || platform == 'responsive'){
        window.open('/?setDesignMode=off&setMode=pc&cachepreview=y');
    }
    if(platform == 'mobile'){
        window.open('/?setDesignMode=off&setMode=mobile&cachepreview=y');
    }
    if(platform == 'fammerce'){
        window.open('/?setDesignMode=off&setMode=fammerce&cachepreview=y');
    }
}
function getCacheSearchFormParams()
{	
    return {'page':$("input[name='page']").val(),'cache_area':$("input[name='cache_area']:checked").val(),'platform':$("input[name='platform']:checked").val(),'keyword':$("input[name='keyword']").val(),'auto_generation':$("select[name='auto_generation'] option:selected").val(),'cache_use':$("select[name='cache_use'] option:selected").val(),'search_favorite':$("select[name='search_favorite'] option:selected").val()};
}
function allGoodsDisplayCache(){
    var params =  getCacheSearchFormParams();
    var url = '../setting_process/allGoodsDisplayCache';
    params['createCached'] = 1;
    $.ajax({
        'type' : "get",
        'dataType' : 'json',
        'url' : url,
        'data' : params,
        'success' : function(result){
            var msg = '<div class="left">' 
                + '일괄 캐시파일 생성 처리 결과입니다.' 
                + '<div class="pdt5">'
                + '대상 : ' + result.iReq 
                + '<br>성공 : ' + result.iSuc 
                + '<br>실패 : ' + result.iErr
                + '</div>'
                + '</div>';
            var callback = {'btn_class':'btn small', 'btn_title':'확인', 'btn_action':'get_contents();closeDialog(\'openDialogLayer\');'};    
            openDialogAlert(msg, 400, 200, function(){}, callback);
        }
    });
}
function chgGoodsDisplayCache(bObj, pObj){    
    var bObj   = $(bObj).find("span");
    if( bObj.hasClass('link') ){
        openDialogAlert('<div class="left">해당 상품디스플레이는 자동으로 상품이 진열되므로<br>캐시파일을 생성할 수 없습니다.</div>', 400, 170);
        return false;
    }
    var sData   = {'createCached':1, 'display_seq':pObj.display_seq, 'display_seq':pObj.display_seq, 'display_tab_index':pObj.display_tab_index, 'perpage':pObj.perpage, 'kind':pObj.kind};
    $.ajax({
        type : "post",
        dataType : 'json',
        data : sData,
        url : "../setting_process/createGoodsDisplayCache",			
        success : function(result){            
            var msg = '<div class="left">' 
                + '캐시파일 생성 처리 결과입니다.' 
                + '<div class="pdt5">'
                + '대상 : ' + result.iReq 
                + '<br>성공 : ' + result.iSuc 
                + '<br>실패 : ' + result.iErr
                + '</div>'
                + '</div>';
            var callback = {'btn_class':'btn small', 'btn_title':'확인', 'btn_action':'get_contents();closeDialog(\'openDialogLayer\');'};
            openDialogAlert(msg, 400, 200, function(){}, callback);
        }
    });
}
function viewGoodsDisplayCache(bObj, pObj){    
    var bObj   = $(bObj).find("span");    
    var sUrl    = "../../main/viewGoodsDisplayCache";
    sUrl    += "?display_seq=" + pObj.display_seq;
    sUrl    += "&display_tab_index=" + pObj.display_tab_index;
    sUrl    += "&perpage=" + pObj.perpage;
    sUrl    += "&kind=" + pObj.kind;
    window.open(sUrl);
}
function setGoodsDisplayCache(bObj, pObj){   
    var bObj   = $(bObj).find("span");
    if( bObj.hasClass('link') ){
        openDialogAlert('캐시파일이 존재하지 않습니다. 캐시파일을 생성해 주세요.', 400, 150);
        return false;
    }    
    var chgStatus   = 'n';
    if( bObj.hasClass('off') ){
        chgStatus   = 'y';
    }    
    var sData   = "display_seq=" + pObj.display_seq;
    sData       += "&display_tab_index=" + pObj.display_tab_index;
    sData       += "&perpage=" + pObj.perpage;
    sData       += "&kind=" + pObj.kind;
    sData       += "&status=" + chgStatus;
    $.ajax({
        type        : 'post',
        dataType    : 'json',
        data        : sData,
        url         : '../setting_process/setGoodsDisplayCache',			
        success    : function(result){
            if(result.code == '10' && chgStatus == 'y'){
                openDialogAlert('<div class=\'left\'>해당 상품디스플레이의 캐시파일이 사용으로 설정되었습니다.<br>앞으로 해당 상품디스플레이의 노출되는 상품 및 정보가 변경되었을 경우<br>최신의 캐시파일로 생성(수동/자동)해 주십시오.</div>', 450, 200);
            }else if(result.code == '10' && chgStatus == 'n'){                
                openDialogAlert('해당 상품디스플레이의 캐시파일이 미사용으로 설정되었습니다.', 450, 150);
            }else{
                openDialogAlert('설정 중 오류가 발생하였습니다.', 450, 150);
            }
            get_contents();
        }
    });
}
function set_availability(){
    var obj = $("select[class='cache-search'],input[class='cache-search'],button[class='cache-search']");
    if($("input[name='cache_area']:checked").val()=='display'){
       obj.attr('disabled', false);
    }else{
       obj.attr('disabled', true);        
    }
}
function get_contents(){    
    var params  = getCacheSearchFormParams();        
    var url = './cacheDisplayAjax';
    if($("input[name='cache_area']:checked").val() == 'main') url = './cacheMainAjax';
    $.ajax({
        'type' : "get",
        'dataType' : 'html',
        'url' : url,
        'data' : params,
        'success' : function(result){
            $("div#cacheListContents").html(result);
        }
    });    
}
function setAutoGeneration(bObj, pObj){
    var sData = {'display_seq':pObj.display_seq,'display_tab_index':pObj.display_tab_index,'auto_generation':pObj.auto_generation};
    $.ajax({
        type        : 'post',
        dataType    : 'json',
        data        : sData,
        url         : '../setting_process/setAutoGeneration',
        success    : function(result){            
            if( result.code == 300 ){
                openDialogAlert('캐시파일 자동생성은 최대 50개까지 가능합니다.', 450, 150);
            }
            get_contents();
        }
    });
}
function setFavorite(bObj, pObj){
    var sData = {'display_seq':pObj.display_seq,'display_tab_index':pObj.display_tab_index,'favorite':pObj.favorite};
    $.ajax({
        type        : 'post',
        dataType    : 'json',
        data        : sData,
        url         : '../setting_process/setFavorite',
        success    : function(result){
            get_contents();
        }
    });
}
function setAllFavorite(bObj){
    bObj = $(bObj);    
    var sAllSeq     = '';
    var sFavorite   = 'y';
    if(bObj.hasClass("checked")){
       sFavorite = 'n';
    }
    $("input[name='auto_generation[]']").each(function(){
        sAllSeq += $(this).val() + ',';
    });    
    var sData  = {'favorite':sFavorite,'seqs':sAllSeq};
    $.ajax({
        type        : 'post',
        dataType    : 'json',
        data        : sData,
        async       : false,
        url         : '../setting_process/setAllFavorite',
        success    : function(result){
        
        }
    });    
    if(bObj.hasClass("checked")){
        $("span.icon-star-gray").removeClass("checked");
    }else{
        $("span.icon-star-gray").removeClass("checked");
        $("span.icon-star-gray").addClass("checked");
    }
    
}
function parse_query_string(query) {
    var vars = query.split("&");
    var query_string = {};
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        var key = decodeURIComponent(pair[0]);
        var value = decodeURIComponent(pair[1]);
        // If first entry with this name
        if (typeof query_string[key] === "undefined") {
            query_string[key] = decodeURIComponent(value);
            // If second entry with this name
        } else if (typeof query_string[key] === "string") {
            var arr = [query_string[key], decodeURIComponent(value)];
            query_string[key] = arr;
            // If third or later entry with this name
        } else {
            query_string[key].push(decodeURIComponent(value));
        }
    }
    return query_string;
}
function chkAutoGeneration(pObj){   
    var bObj = $("input[name='auto_generation[]']").eq(pObj.idx);
    if(pObj.auto_generation=='y'){
        bObj.attr("checked",true);
    }
    if( pObj.cache_use!='y' || !pObj.cache_file ){
        bObj.attr("disabled",true);
    }    
}
function goCachePage(sPage){    
   var obj = parse_query_string(sPage); 
   $("form#cache-search-form input[name='page']").val(obj.page);
   $("form#cache-search-form input[name='cache_area'][value='"+obj.cache_area+"']").attr("checked", true);
   $("form#cache-search-form input[name='platform'][value='"+obj.platform+"']").attr("checked", true);
   $("form#cache-search-form input[name='keyword']").val(obj.keyword);
   $("form#cache-search-form select[name='auto_generation'] option[value='"+obj.auto_generation+"']").attr("selected", true);
   $("form#cache-search-form select[name='cache_use'] option[value='"+obj.cache_use+"']").attr("selected", true);
   $("form#cache-search-form select[name='search_favorite'] option[value='"+obj.search_favorite+"']").attr("selected", true);
   get_contents();
}
function infoDisplayCache(){	
	openDialog("캐시 안내", "info-display-cache", {"width":"1000","height":"300","show" : "fade","hide" : "fade"});		
}
function infoDisplayCacheView(){	
	openDialog("캐시파일 동작", "info-display-cache-view", {"width":"500","height":"230","show" : "fade","hide" : "fade"});		
}
function infoDisplayCacheAuto(){	
	openDialog("캐시파일 자동생성", "info-display-cache-auto", {"width":"800","height":"200","show" : "fade","hide" : "fade"});		
}