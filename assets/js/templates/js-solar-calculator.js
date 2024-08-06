document.addEventListener("DOMContentLoaded", function () {
    var sliders = document.querySelectorAll(".range_selector input[type='range']");
    var sliderTexts = document.querySelectorAll('.single_solar_calc_field input[type="text"]');
    sliders.forEach(function (slider) {
        formatCost(slider);
        sliderSlide(slider);

        slider.addEventListener("input", function () {
            formatCost(slider);
            sliderSlide(slider);
        });

        slider.addEventListener("change", function () {
            formatCost(slider);
            sliderSlide(slider);
        });
    });

    sliderTexts.forEach(function (sliderText) {
        sliderText.addEventListener("input", function () {
            updateSlider(sliderText);
            formatCost(sliderText);
            sliderSlide(document.querySelector(`#${sliderText.id.replace('_text', '')}`));
        });
    });
});

function sliderSlide(slider) {
    var sliderVal = slider.value;
    var minValue = slider.min;
    var maxValue = slider.max;
    var newValue = ((sliderVal - minValue) / (maxValue - minValue)) * 100;

    var color = `linear-gradient(90deg, rgba(0, 40, 82, 1) ${newValue}%, rgba(217, 228, 238, 1) ${newValue}%)`;
    slider.style.background = color;

    if (newValue > 40 && newValue <= 85) {
        slider.classList.add("ahead");
        slider.classList.remove("end");
    } else if (newValue > 85) {
        slider.classList.remove("ahead");
        slider.classList.add("end");
    } else {
        slider.classList.remove("ahead");
        slider.classList.remove("end");
    }

    var formattedMin = Number(slider.min).toLocaleString('en-IN');
    var formattedMax = Number(slider.max).toLocaleString('en-IN');

    slider.setAttribute('data-min', formattedMin);
    slider.setAttribute('data-max', formattedMax);
}
function formatCost(element) {
    var value;
    var isSlider = element.tagName.toLowerCase() === 'input' && element.type === 'range';
    var isTextInput = element.tagName.toLowerCase() === 'input' && element.type === 'text';

    if (isTextInput) {
        // Remove currency symbol and commas for parsing
        value = element.value.replace('₹', '').replace(/,/g, '');
    } else if (isSlider) {
        value = element.value;
    }

    value = Number(value).toLocaleString();

    if (isTextInput) {
        // Apply formatting based on the class of the text input
        if (element.classList.contains("format_value")) {
            element.value = '₹' + value;
        } else {
            element.value = value;
        }
    } else if (isSlider) {
        var textInput = document.querySelector(`#${element.id}_text`);
        if (textInput) {
            // Apply formatting based on the class of the slider
            if (element.classList.contains("format_value")) {
                textInput.value = '₹' + value;
            } else {
                textInput.value = value;
            }
        }
    }
}



function updateSlider(textInput) {
    var sliderId = textInput.id.replace('_text', '');
    var slider = document.getElementById(sliderId);
    if (slider) {
        var min = parseFloat(slider.min);
        var max = parseFloat(slider.max);
        var value = textInput.value.replace('₹', '').replace(/,/g, '');
        value = parseFloat(value);
        
        value = Math.max(min, Math.min(value, max));
        slider.value = value;
        formatCost(slider);
    }
}

function formatNumber(number) {
    return Number(number).toLocaleString();
}

jQuery(document).ready(function($){
    jQuery(function ($) {
		$('.faq_que').click(function (j) {
			var dropDown = $(this).closest('.single_faq').find('.faq_content');
			$(this).closest('.solar_faqs_wrap').find('.faq_content').not(dropDown).slideUp();
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
			} else {
				$(this).closest('.solar_faqs_wrap').find('.faq_que.active').removeClass('active');
				$(this).addClass('active');
			}
			dropDown.stop(false, true).slideToggle();
			j.preventDefault();
		});
	});
});

document.addEventListener('DOMContentLoaded', function () {
const ctx = document.getElementById('barChart').getContext('2d');

    var barChart = new Chart(ctx, {
        data: {
            labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15"],
            datasets: [
                {
                    type: 'line',
                    label: 'Initial investment',
                    data: [23000, 17000, 14000, 10000, 18000, 16000, 14000, 12000, 10000, 8000, 6000, 5000, 3000, 2000, 1000],
                    borderColor: "#0000FF"
                },
                {
                type: 'bar',
                label: 'Cumulative Income',
                data: [2000, 6000, 10000, 14000, 18000, 22000, 26000, 30000, 38000, 44000, 50000, 60000, 65000, 75000, 80000],
                backgroundColor: "#FF6347"
            }]
        },
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 80000,
                    ticks: {
                        stepSize: (80000 - 0) / 4,
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    },
                    grid: {
                        drawBorder: false,
                        borderColor: 'transparent',
                        color: 'transparent'
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        borderColor: 'transparent',
                        color: 'transparent'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                }
            },
            elements: {
                point:{
                    radius: 0
                }
            }
        }
    });
});