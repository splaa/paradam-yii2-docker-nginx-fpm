let main = {
	back: function() {
		let referrer = document.referrer;
		if (!referrer.match('paradam')) {
			window.location = '/';
			return;
		}
		window.history.back();

		return false;
	},
	addQuestion: function() {
		$('.js-input-plus').trigger('click');
	},
	initTooltip: function() {
		$('.tooltip').tooltipster({
			theme: 'tooltipster-shadow',
			trigger: 'click'
		});
	}
}

// Init Main function when page is loaded
$(document).ready(function() {
	main.initTooltip();
	$('.mask-content').on('click', function(){
		$('#nav-toggle').prop('checked', false);
	})
});

let pageService = document.getElementById("service_block_form");

if (pageService !== null) {
// SERVICE COST
	let slider = document.getElementById("costRange");
	let price = document.getElementById("totalPrice");
	let output = document.getElementById("totalPriceOutput");

	if (price) {
		price.innerHTML = getCurrencyValue(slider.value);
	}

	if (output) {
		output.innerHTML = getPercentPrice(slider.value, true);
	}

	if (slider) {
		slider.oninput = function () {
			price.innerHTML = getCurrencyValue(this.value);
			output.innerHTML = getPercentPrice(this.value, true);
		}

		slider.onmouseup = function () {
			$('#costRange').val(getPercentPrice($('#costRange').val(), false));
		}
	}

// DAY COUNTER
	let sliderDay = document.getElementById("dayRange");
	let outputDay = document.getElementById("totalDay");

	if (outputDay) {
		outputDay.innerHTML = sliderDay.value + ' дня';
	}

	if (sliderDay) {
		sliderDay.oninput = function () {
			outputDay.innerHTML = this.value + ' дня';
		}
	}
}

$(document).on('click', '#button_add_question', function () {
	$('.ib_add_button').trigger('click');
})

//Tabs And Action
$(document).on("click", ".tabs__item", function () {
	$(".tabs__item").removeClass("tabs__item_active");
	$(this).addClass("tabs__item_active");
	$(".tabs__container").hide();

	let type = $(this).data('type');
	$(this).parents('form').find('input[name="type"]').val(type);
});

//Tabs And Show Content
$(document).on("click", ".tabs__item_click", function () {
	$(".tabs__item").removeClass("tabs__item_active");
	$(this).addClass("tabs__item_active");
	$(".tabs__container").hide();
	let id = $(this).data("tab");
	if (id) {
		$(id).show();
	}
});

$('.multiple-input').on('afterInit', function(){
	// calls on after initialization event
	$('.multiple-input-list__item').each(function(k, v){
		$(v).prepend('<label class="inputBlock-top__label">Вопрос ' + (parseInt(k) + 1) + '</label>');
	});
}).on('beforeAddRow', function(e, row, currentIndex) {
	// calls on before add row event
}).on('afterAddRow', function(e, row, currentIndex) {
	// calls on after add row event
	//console.log(currentIndex);
	$(row).prepend('<label class="inputBlock-top__label">Вопрос ' + (parseInt(currentIndex)+1) + '</label>');
}).on('beforeDeleteRow', function(e, row, currentIndex){
	// row - HTML container of the current row for removal.
	// For TableRenderer it is tr.multiple-input-list__item
	// calls on before remove row event.
	return confirm('Are you sure you want to delete row?')
}).on('afterDeleteRow', function(e, row, currentIndex){
	// calls on after remove row event
	// console.log(row);
}).on('afterDropRow', function(e, item){
	// console.log('calls on after drop row', item);
});

$('.hover_block').on('click', '.backButton', function(){
	$(this).parents('section').toggleClass("slide");
	$('html, body, #app_container').removeAttr('style');
});

$(document).on('input', '#desc_servise, #name_servise', function () {
	let max = $(this).attr('data-max');

	if($(this).val().length <= max){
		$(this).parents('.inputBlock').find('.inputBlock-top__current').text($(this).val().length);
	} else{
		$(this).val($(this).val().substr(0, max));
	}
});

// Open slide page
function windowLoaderFunk(html){
	$('html, body, #app_container').css({
		'overflow' : 'hidden',
		'-moz-overscroll-behavior-y' : 'none',
		'-o-overscroll-behavior-y' : 'none',
		'-webkit-overscroll-behavior-y' : 'none',
		'overscroll-behavior-y' : 'none'
	});
	$('#page_service').find('.desc').html(html);
	$('#page_service').toggleClass("slide");
}
function getCurrencyValue(amount) {
	return amount + currency_bits;
}
function getPercentPrice(amount, format) {
	if (format) {
		return getCurrencyValue(Math.round(parseFloat(amount) * (100 - commision_percent_service)) / 100);
	} else {
		return Math.round(parseFloat(amount) * (100 - commision_percent_service)) / 100;
	}
}