(function(a,d){a(d).ready(function(){a(".field-error").change(function(){a(this).removeClass("field-error")})});a(d).ready(function(){a(".js-form-submit").wrap('<div class="form-submit-wrap"></div>');a(".js-form-submit").after('<div class="form-submit-mask"></div>')});a(d).ready(function(){function f(b){var c=b.parents(".js-form"),b=b.data("form-id");0===c.length&&void 0!==b&&(c=a("#"+b));return c}a(".js-form-submit").each(function(){var b=a(this),c=f(b);b.on("click",function(){a(d).data("button",
b)});c.on("submit",function(){a(d).data("form",c)})});a(window).on("beforeunload",function(){var b=a(d).data("form"),c=a(d).data("button");if(void 0!==b){var e='[data-form-id="'+b.attr("id")+'"]';a(".js-form-submit",b).add(e).addClass("loading");void 0!==c&&(b=c.siblings(".form-submit-mask"),e='<div id="fountainG">,<div id="fountainG_1" class="fountainG"></div>,<div id="fountainG_2" class="fountainG"></div>,<div id="fountainG_3" class="fountainG"></div>,<div id="fountainG_4" class="fountainG"></div>,<div id="fountainG_5" class="fountainG"></div>,<div id="fountainG_6" class="fountainG"></div>,<div id="fountainG_7" class="fountainG"></div>,<div id="fountainG_8" class="fountainG"></div>,</div>'.split(","),
void 0!==c.data("loader")&&0===a("#fountainG",b).length&&(b.append(e.join("")),c.addClass("loading-loader")))}})})})(jQuery,document);
