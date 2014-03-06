/**
 * Functions:
 * #Set available hot keys
 * $.hostKey(":setCodes", "A B C");
 *
 * CSS:
 * .hot-key-highlight {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	-webkit-box-shadow: 0 0 1px 1px #FFFFFF;
	box-shadow: 0 0 1px 1px #FFFFFF;
	background-color: #3A87AD;
	border-radius: 9px;
	color: #FFFFFF;
	font-size: 11.844px;
	font-weight: bold;
	height: 18px;
	line-height: 14px;
	margin: -8px 0 0 -8px;
	padding: 2px 1px 2px 0;
	text-align: center;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	vertical-align: baseline;
	width: 18px;
	white-space: nowrap;
	z-index: 1;
	}
 *
 * Use:
 * #All tag has class "hot-key"
 * Params:
 *      data-hot-key-container="#id container"
 *      data-hot-key-label="Label use take hot key"
 *      data-hot-key-code="Hot key code"
 *      data-hot-key-action="click, focus, js or trigger"
 *      data-hot-key-trigger="action name"
 *      data-hot-key-z-index="1031" #css: z-index of highlight(suggest)
 *      data-hot-key-position="fixed" #css: position of highlight(suggest)
 *
 * #Add tag by $.hostKey(selector, settings);
 *
 */

(function (w, d, $) {
	if ($ && !$.hostKey) {
		var codes = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 0 1 2 3 4 5 6 7 8 9";

		$.extend({
			hostKey: function (elements, settings) {
				var self = this;
				var result = false;

				if (!this.ini || this.ini == undefined) {
					this.ini = true;

					this.shiftUp = 0;
					this.shiftDown = 0;
					this.elements = [];
					this.elements.add = function (element) {
						for (var i = 0; i < this.length; i++) {
							if (element[0] === this[i][0]) {
								return false;
							}
						}
						if (element.data("hot-key-code"))
							this.unshift(element);
						else this.push(element);
						return true;
					};
					this.elements.remove = function (element) {
						for (var i = 0; i < this.length; i++) {
							if (element[0] === this[i][0]) {
								this.splice(i, 1);
								return true;
							}
						}
						return false;
					}

					this.showSuggest = function () {
						if (!this.showedSuggest) {
							this.showedSuggest = true;
							this.keyCodes = [];
							this.suggests = {};
							for (var i = 0; i < this.elements.length; i++) {
								var settings = {
									keyCode: false,
									container: false
								};
								var set = this.elements[i].data("hot-key-settings");
								if (set) {
									$.extend(settings, set);
									if (settings.keyCode) this.elements[i].data("hot-key-code", settings.keyCode);
									if (settings.label) this.elements[i].data("hot-key-label", settings.label);
									if (settings.action) this.elements[i].data("hot-key-action", settings.action);
									if (settings.trigger) this.elements[i].data("hot-key-trigger", settings.trigger);
									if (settings.position) this.elements[i].data("hot-key-position", settings.position);
									if (settings.zIndex) this.elements[i].data("hot-key-z-index", settings.zIndex);
								}

								var set = this.elements[i].data("hot-key-container");
								if (set) settings.container = $(set);

								if (!settings.keyCode) settings.keyCode = this.getKeyCode(this.elements[i]);

								if (settings.keyCode) {
									if (-1 == $.inArray(settings.keyCode, this.keyCodes)) {
										var highlight = this.elements[i].data("hot-key-highlight");
										if (!highlight) {
											highlight = $("<strong/>").addClass("hot-key-highlight").hide();
											$("body").append(highlight);
											this.elements[i].data("hot-key-highlight", highlight);
										}

										var pos = settings.container ? settings.container.offset() : this.elements[i].offset();
										//var hei = settings.container ? settings.container.outerHeight() :this.elements[i].outerHeight();
										var wid = settings.container ? settings.container.outerWidth() : this.elements[i].outerWidth();

										var set = this.elements[i].data("hot-key-position");
										if (set == "fixed") pos.top -= $(window).scrollTop();

										highlight.css({
											position: "absolute",
											top: pos.top,
											left: pos.left + wid
										});

										if (set) highlight.css("position", set);

										var set = this.elements[i].data("hot-key-z-index");
										if (set) highlight.css("z-index", set);

										highlight.text(String.fromCharCode(settings.keyCode).toLowerCase()).show();

										this.keyCodes.push(settings.keyCode);
										this.suggests[settings.keyCode] = this.elements[i];
									}
								}
							}
						}
					}

					this.hideSuggest = function () {
						for (var i = 0; i < this.elements.length; i++) {
							var highlight = this.elements[i].data("hot-key-highlight");
							if (highlight) highlight.hide();
						}
						this.showedSuggest = false;
						this.keyCodes = [];
						this.shiftDown = 0;
						this.shiftUp = 0;
					}

					this.getKeyCode = function (element) {
						var code = element.data("hot-key-code");

						if (code && !$.isNumeric(code)) code = code.toUpperCase().charCodeAt(0);

						if (code && $.inArray(code, this.keyCodes) > -1) code = false;

						if (!code) {
							switch (element.prop("tagName").toUpperCase()) {
								default :
								case "A":
								case "BUTTON":
									code = $.trim(element.text());
									break;
								case "INPUT":
									if (element.attr("type").toUpperCase() == "BUTTON") {
										code = $.trim(element.val());
										break;
									}
								case "SELECT":
								case "TEXTAREA":
									code = $.trim(element.data("hot-key-label"));
									if (!code) {
										code = element.parents("label").first();
										if (code.length == 0) {
											var id = element.attr("id");
											if (id) code = $("label[for=" + id + "]").first();
										}
										if (code.length == 0) {
											code = false;
										} else {
											code = $.trim(code.text());
										}
									}
									break;
							}

							if (!code) code = codes;

							if (code) {
								var hks = code.split(/\s+/);
								var hk = this.selectCode(hks);
								if (hk) code = hk;

								if (code != codes) {
									if (!$.isNumeric(code)) {
										hks = code.split(/\s*/);
										var hk = this.selectCode(hks);
										if (hk) code = hk;
									}

									if (!$.isNumeric(code)) {
										hks = codes.split(/\s+/);
										var hk = this.selectCode(hks);
										if (hk) code = hk;
									}

									if (!$.isNumeric(code)) code = false;
								}
							}
							element.data("hot-key-code", code);
						}
						return code;
					}

					this.selectCode = function (hks) {
						for (var i = 0; i < hks.length; i++) {
							var hk = hks[i][0].toUpperCase();
							if ($.inArray(hk, codes.split(/\s+/)) > -1 && -1 == $.inArray(hk = hk.charCodeAt(0), this.keyCodes)) {
								return hk;
								break;
							}
						}
						return false;
					}

					this.action = function (element) {
						var action = element.data("hot-key-action");
						switch (action) {
							case "click":
								element.click();
								break;
							case "focus":
								if (element.is(":focus"))
									element.select();
								else {
									element.focus().focusin();
								}
								break;
							case "trigger":
								var action = $.trim(element.data("hot-key-trigger"));
								if (action) {
									action = action.split(",");
									for (var i = 0; i < action.length; i++)
										element.trigger(action[i]);
								}
								break;
							case "js":
								var action = $.trim(element.data("hot-key-js"));
								if (action) {
									eval(action);
								}
								break;
							default :
								switch (element.prop("tagName").toUpperCase()) {
									case "A":
									case "BUTTON":
										element.click();
										break;
									case "INPUT":
										if (element.attr("type").toUpperCase() == "BUTTON") {
											element.click();
											break;
										}
									case "SELECT":
									case "TEXTAREA":
										if (element.is(":focus"))
											element.select();
										else {
											element.focus().focusin();
										}
										break;
									default :
										element.focus().focusin();
								}
						}
					}
				}

				switch (elements) {
					case ":setCodes":
						codes = settings;
						break;
					case ":hotKey":
						if (this.elements && this.elements.length) {
							var doAction = false;

							if (settings == 27 && this.shiftDown > 0) {
								clearTimeout(this.shiftTimeout);
								this.hideSuggest();
								result = true;
							} else if (this.shiftDown > 1) {
								if ($.inArray(settings, this.keyCodes) > -1) {
									this.action(this.suggests[settings]);
									doAction = true;
								}
								result = true;
							}

							if ((!result && this.shiftDown - this.shiftUp < 2) ||
								(doAction && this.shiftDown >= 3 && this.shiftUp >= 3)) {
								clearTimeout(this.shiftTimeout);
								this.hideSuggest();
							}
						}
						break;
					case ":showSuggest":
						if (this.elements && this.elements.length) {
							this.shiftUp = 4;
							this.shiftDown = 4;
							if (!this.showedSuggest) this.showSuggest();
						}
						break;
					case ":shiftDown":
						if (this.elements && this.elements.length) {
							if (this.shiftDown >= 0 && this.shiftDown <= 3) {
								this.shiftDown++;
								clearTimeout(this.shiftTimeout);

								if (this.shiftDown < 3) {
									if (1 == this.shiftDown - this.shiftUp) {
										this.shiftTimeout = setTimeout(function () {
											if (self.shiftDown == 2) {
												self.hideSuggest();
											} else {
												self.shiftUp = 0;
												self.shiftDown = 0;
											}
										}, this.shiftDown > 1 ? 2000 : 1500);
									}

									if (this.shiftDown > 1) {
										this.showSuggest();
									}
								}
								/* else { // == 3

								 }*/
							}

							result = true;
						}
						break;
					case ":shiftUp":
						if (this.elements && this.elements.length) {
							if (this.shiftDown > 0 && this.shiftDown <= 3) {
								this.shiftUp++;
							}

							if (this.shiftDown - this.shiftUp > 0) {
								self.hideSuggest();
							}

							result = true;
						}
						break;
					case ":remove":
						if ($.isArray(settings)) {
							for (var i = 0; i < settings.length; i++) {
								this.elements.remove($(settings[i]));
							}
						} else {
							settings = $(settings);
							if (settings.length > 1) {
								for (var i = 0; i < settings.length; i++) {
									this.elements.remove($(settings[i]));
								}
							} else {
								this.elements.remove(settings);
							}
						}
						break;
					default:
						if ($.isArray(elements)) {
							for (var i = 0; i < elements.length; i++) {
								this.elements.add($(elements[i].element).data("hot-key-settings", elements[i].settings));
							}
						} else if ($.isPlainObject(elements)) {
							this.elements.add($(elements.element).data("hot-key-settings", elements.settings));
						} else {
							elements = $(elements);
							if (elements.length > 1) {
								for (var i = 0; i < elements.length; i++) {
									this.elements.add($(elements[i]).data("hot-key-settings", settings));
								}
							} else {
								this.elements.add(elements.data("hot-key-settings", settings));
							}
						}

						result = true;
				}

				return result;
			}
		});


		function ini(elements) {
			if (!elements) elements = $(".hot-key");
			if (elements && elements.length) {
				$.hostKey(elements);
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
			if ($.inArray(event.keyCode, [16, 17]) > -1 && event.shiftKey && event.ctrlKey && !event.altKey) {
				$.hostKey(":showSuggest");
			} else if (90 == event.keyCode && !event.shiftKey && !event.ctrlKey && event.altKey) {
				$.hostKey(":showSuggest");
			} else if (16 == event.keyCode && event.shiftKey && !event.ctrlKey && !event.altKey) {
				$.hostKey(":shiftDown");
			} else if (!event.ctrlKey && !event.altKey && (27 == event.keyCode || $.inArray(String.fromCharCode(event.keyCode), codes.split(/\s+/)) > -1)) {
				if ($.hostKey(":hotKey", event.keyCode)) {
					event.preventDefault();
				}
			}
			//console.log(event);
		}).keyup(function (event) {
				if (event.keyCode == 16 && !event.shiftKey && !event.ctrlKey && !event.altKey) {
					$.hostKey(":shiftUp");
				}
				//console.log(event);
			});
	}
})(window, document, "undefined" != typeof jQuery ? jQuery : null);