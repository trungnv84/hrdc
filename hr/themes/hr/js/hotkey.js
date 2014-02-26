(function (w, d, $) {
	if ($ && !$.shiftKey) {
		$.extend({
			shiftKey: function (elements, settings) {
				var self = this;
				switch (elements) {
					case ":suggest":
						if (!this.shiftDown) this.shiftDown = 0;

						if (this.shiftDown >= 0 && this.shiftDown < 3) {
							this.shiftDown++;
							clearTimeout(this.shiftTimeout);

							if (this.shiftDown < 3) {
								this.shiftTimeout = setTimeout(function () {
									if (self.shiftDown == 2) {
										self.hideSuggest();
									}
									self.shiftDown = 0;
								}, this.shiftDown * 1000);

								if (this.shiftDown > 1) {
									this.showSuggest();
								}
							}
							/* else { // == 3

							 }*/
							console.log(this.shiftDown);
						} else this.shiftDown = 0;

						break;
					default:
						if (!this.elements) {
							this.elements = [];
							this.elements.add = function (element) {
								for (var i = 0; i < this.length; i++) {
									if (element[0] === this[i][0]) {
										return;
									}
								}
								this.push(element);
							}
						}

						if ($.isArray(elements)) {
							for (var i = 0; i < elements.length; i++) {
								this.elements.add($(elements[i].element).data("hot-key-setting", elements[i].settings));
							}
						} else if ($.isPlainObject(elements)) {
							this.elements.add($(elements.element).data("hot-key-setting", elements.settings));
						} else {
							elements = $(elements);
							if (elements.length > 1) {
								for (var i = 0; i < elements.length; i++) {
									this.elements.add($(elements[i]).data("hot-key-setting", settings));
								}
							} else {
								this.elements.add($(elements).data("hot-key-setting", settings));
							}
						}
						this.elements = $.unique(this.elements);
				}

				this.showSuggest = function () {
					for (var i = 0; i < this.elements.length; i++) {
						var setting = {
							keyCode: false,
							label: false
						};
						var set = this.elements[i].data("hot-key-setting");
						if (set) $.extend(setting, set);

						if (!setting.keyCode) setting.keyCode = this.getKeyCode(this.elements[i]);
						this.elements[i].data("hot-key-setting", setting);

						if (setting.keyCode) {
							var highlight = this.elements[i].data("hot-key-highlight");
							if (highlight) {
								highlight.text(String.fromCharCode(setting.keyCode)).show();
							} else {
								var pos = setting.label ? setting.label.position() : this.elements[i].position();
								//var hei = setting.label ? setting.label.outerHeight() :this.elements[i].outerHeight();
								var wid = setting.label ? setting.label.outerWidth() : this.elements[i].outerWidth();
								highlight = $("<strong/>").addClass("hot-key-highlight")
									.text(String.fromCharCode(setting.keyCode))
									.css({
										position: "absolute",
										top: pos.top,
										left: pos.left + wid
									});
								$("body").append(highlight);
								this.elements[i].data("hot-key-highlight", highlight);
							}
						}
					}
				}

				this.getKeyCode = function (element) {
					var code = element.data("hot-key-code");
					if (!code) {
						switch (element.prop("tagName").toUpperCase()) {
							case "A":
								code = element.text();
								break;
							case "INPUT":
							case "SELECT":
							case "TEXTAREA":
								code = element.parents("label").first();
								if (code.length == 0) {
									code = element.attr("id");
									code = $("label[for=" + code + "]").first();
								}
								if (code.length == 0) {
									code = "a";//TODO change...
								} else {
									code = code.text();
								}
								break;
						}
						if (code) code = code.toLowerCase().charCodeAt(0);
					}
					element.data("hot-key-code", code);
					return code;
				}

				this.hideSuggest = function () {
					for (var i = 0; i < this.elements.length; i++) {
						var highlight = this.elements[i].data("hot-key-highlight");
						if (highlight) highlight.hide();
					}
				}
			}
		});
	}

	function ini(elements) {
		if (!elements) elements = $(".hot-key");
		if (elements && elements.length) {
			$.shiftKey(elements);
		}
	}

	if ($("body").length) {
		ini();
	} else {
		$(d).ready(function () {
			ini();
		});
	}

	$(d).keydown(function (event) {
		if (event.key == "Shift" && event.keyCode == 16 && event.shiftKey) {
			$.shiftKey(":suggest");
		} else {
			if ($.shiftKey(":hotKey", event.keyCode)) {
				event.preventDefault();
			}
		}
		console.log(event);
	});
})(window, document, "undefined" != typeof jQuery ? jQuery : null);