$(function () {
    var changeRowNumbers, couponId, couponMatches, couponWrapper, interval, rowNumbers, secondsToUpdate, submitButton, textContainer, that;
    $("a.user-remove").on("click", function () {
        if (!confirm("Är du säker på att du vill ta bort den här användaren?")) {
            false;
        }
    });
    couponWrapper = $("#coupon-wrapper");
    if ($(couponWrapper).length) {
        couponId = couponWrapper.data('id');
        secondsToUpdate = $("span.update-seconds");
        interval = function (ms, func) {
            return setInterval(func, ms);
        };
        interval(20000, function () {
            couponWrapper.load("/kuponger/" + couponId + "/uppdatering");
            return secondsToUpdate.html(20);
        });
        interval(1000, function () {
            return secondsToUpdate.html(parseInt(secondsToUpdate.html()) - 1);
        });
    }
    couponMatches = $("#coupon-matches");
    if ($(couponMatches).length) {
        rowNumbers = $("span.row-numbers");
        submitButton = $("div#coupon-submit-container");
        textContainer = $("div#rows-container");
        that = this;
        changeRowNumbers = function () {
            var errors, message, total;
            total = 1;
            errors = [];
            $(that).find("li").each(function () {
                var checkedBoxes;
                checkedBoxes = $(this).find("input[type='checkbox']:checked").length;
                if (checkedBoxes > 0) {
                    total *= checkedBoxes;
                } else {
                    total *= 1;
                }
                rowNumbers.html(total);
                return this;
            });
            if (total > 12000) {
                submitButton.hide();
                textContainer.addClass("alert-danger").removeClass("alert-success");
                message = "Din kupong får max vara 12000 rader";
                textContainer.append("<span class='row-numbers-error'>. " + message + "</span>");
            } else {
                submitButton.show();
                submitButton.find("input").show();
                textContainer.addClass("alert-success").removeClass("alert-danger");
                $("span.row-numbers-error").remove();
                $("div.errors").remove();
            }
            return total;
        };
        $(this).find("li input[type='checkbox']").on('change', function () {
            changeRowNumbers();
            return this;
        });
        submitButton.find("input").on('click', function (e) {
            if (changeRowNumbers() <= 12000 && $("input[name='name']").val() != "") {
                $(this).hide();
            }
            return this;
        });
    }

    if ($("span#admin-update-coupons").length) {
        $("span#submit-all").on('click', function () {
            var delay, elements, index;
            elements = $("body").find("form");
            index = 0;
            delay = function (ms, func) {
                return setInterval(func, ms);
            };

            delay(500, function () {
                var formURL, method, postData;
                if (index <= elements.length) {
                    postData = $($(elements).get(index)).serializeArray();
                    formURL = $($(elements).get(index)).attr("action");
                    method = $($(elements).get(index)).attr("method");
                    $.ajax({
                        url: formURL,
                        type: method,
                        data: postData
                    });
                    index++;
                } else {
                    window.location.href = document.location.pathname;
                }
            });
        });
    }
});
