/**
 * simpleProgress.run(진행률(숫자));
 * 진행률(숫자) 99 초과면 hide 됩니다.
 */
$(function () {
	'use strict';

	if (window.simpleProgress) {
		return false;
	}

	// 간단 퍼센트 프로그래스
	var simpleProgress = {
		layerId: '',
		$layerId: function () {
			return $('#' + this.layerId);
		},
		_init: function () {
			if (this.layerId.length === 0) {
				this._setId(this._createId());
			}
			this._createElement();
		},
		_setId: function (selectorId) {
			this.layerId = selectorId;
		},
		_createId: function () {
			return 'simple-progress-layer-' + Math.floor(Math.random() * 100) + Math.floor(Math.random() * 100);
		},
		_show: function () {
			if (this.$layerId().css('display') === 'none') {
				this.$layerId().show();
			}
		},
		_hide: function (percent) {
			// 100% 숨김
			if (percent > 99) {
				this.$layerId().hide();
			}
		},
		run: function (percent) {
			if (typeof percent !== 'number') {
				console.log('simpleProgress percent 값은 숫자만 가능합니다.');
			}

			this._show();
			this._draw(percent);
			this._hide(percent);
		},
		_draw: function (percent) {
			this.$layerId().text(percent + '%');
		},
		_createElement: function () {
			// 레이어 생성 (중앙 고정)
			var progressLayerElement = document.createElement('div');
			progressLayerElement.id = this.layerId;
			progressLayerElement.style.position = 'fixed';
			progressLayerElement.style.zIndex = '999999';
			progressLayerElement.style.top = '50%';
			progressLayerElement.style.left = '50%';
			progressLayerElement.style.transform = 'translate(-50%, -50%)';
			progressLayerElement.style.msTransform = 'translate(-50%, -50%)';
			progressLayerElement.style.display = 'none';

			// 프로그래스 진행률 text
			progressLayerElement.style.color = 'white';
			progressLayerElement.style.fontSize = '20px';
			progressLayerElement.style.fontWeight = 'bold';
			// 폰트 bold 처리
			progressLayerElement.style.textShadow = '-1px 0 black, 0 1px black, 1px 0 black, 0 -1px black';
			progressLayerElement.innerText = '0%';

			document.body.appendChild(progressLayerElement);
		},
	};

	simpleProgress._init();

	window.simpleProgress = simpleProgress;
});