(function ($) {
//	$.fn.IncrementBox = function (options) {
//		var settings = {
//			timeout: 50,
//			cursor: false
//		};
//		return this.each(function () {
//			if (options) {
//				$.extend(settings, options);
//			}
//			var $this = $(this);
//			var dec = $this.find('.dec');
//			var inc = $this.find('.inc');
//			var counter = $this.find(".amount-num");
//			var iteration = 1;
//			var timeout = 50;
//			var max = $this.find(".amount-num").attr('max')
//			var isDown = false;
//			updateCursor();
//			mousePress(inc, doIncrease);
//			mousePress(dec, doDecrease);
//			function mousePress(obj, func) {
//				focusElement = obj;
//				obj.unbind('mousedown');
//				obj.unbind('mouseup');
//				obj.unbind('mouseleave');
//				obj.bind('mousedown', function () {
//					isDown = true;
//					setTimeout(func, settings.timeout);
//				});
//
//				obj.bind('mouseup', function () {
//					isDown = false;
//					iteration = 1;
////					clearTimeout(mousedownTimeout);
//				});
//
//				obj.bind('mouseleave', function () {
//					isDown = false;
//					iteration = 1;
////					clearTimeout(mousedownTimeout);
//				});
//			}
//			function updateCursor() {
//				if (settings.cursor) {
//					dec.css('cursor', 'pointer');
//					inc.css('cursor', 'pointer');
//				}
//			}
//			function doIncrease() {
//				if (isDown) {
//					var increement = getIncrement(iteration);
//					counter.val(function (i, v) {
//						if(Number(v) < max){
//							return Number(v) + increement;
//						}else{
//							return max;
//						}
//					});
//					iteration++;
//					setTimeout(doIncrease, settings.timeout);
//				} else {
////					clearTimeout(mousedownTimeout);
//				}
//			}
//			function doDecrease() {
//				if (isDown) {
//					var increement = getIncrement(iteration);
//					counter.val(function (i, v) {
//						var result = Number(v) - increement
//						if (result < 0) result = 0;
//						return result;
//					});
//					iteration++;
//					setTimeout(doDecrease, settings.timeout);
//				} else {
////					clearTimeout(mousedownTimeout);
//				}
//			}
//			function getIncrement(iteration) {
//				var increement = 1;
//				if (iteration >= 20) {
//					increement = 10;
//				}
//				if (iteration >= 30) {
//					increement = 100;
//				}
//				if (iteration >= 40) {
//					increement = 1000;
//				}
//				return increement;
//			}
//		});
//		$(".amount-num").keypress(function(event){
//			event = event || window.event;
//			if (event.charCode && event.charCode!=0 && event.charCode!=46 && (event.charCode < 48 || event.charCode > 57) ){
//				return false;
//			}
//		});
//	};
//	$('.amount').IncrementBox({
//		timeout: 75,
//		cursor: true,
//	});
  $(".amount-num").each(function () {
      var min = $(this).attr("min"),
          max = $(this).attr("max"),
          el = $(this);
      el.dec = $(this).parents('.amount').find('.dec');
      el.inc = $(this).parents('.amount').find('.inc');
      el.dec.mousedown(function () {
          var value = el[0].value;
          value--;
          if (!min || value >= min) {
              el[0].value = value;
          }
      });
      el.inc.mousedown(function () {
          var value = el[0].value;
          value++;
          if (!max || value <= max) {
              el[0].value = value++;
          }
      });

  });
})(jQuery);