$(document).ready(function (e) {
    $(".item-title").click(function () {
        var oneHeight = $(".verification").height();
        var signIndex = $(this).parent().index();
        var twoHeight = oneHeight + signIndex * 51;
        var sign = $(this).siblings(".item-content").attr("data-sign");
        var ItemScrollTop = 0;
        var itemHeight = 0;
        $(".item").each(function (index, element) {
            var sign1 = $(this).find(".item-content").attr("data-sign");
            if (sign1 == 1) {
                itemHeight = $(this).height();
            }
        });
        if (sign != 1) {
            $(".item-title").siblings(".item-content").hide();
            $(this).siblings(".item-content").stop(true, true).slideDown(500);
            theDiv = $(this);
            $(".item-content").attr("data-sign", "0");
            $(this).siblings(".item-content").attr("data-sign", "1");
            $(".item-title").addClass("item-title-arrow");
            $(".item-title").removeClass("item-title-arrowUp");
            $(this).removeClass("item-title-arrow");
            $(this).addClass("item-title-arrowUp");
        } else {
            $(".item-title").siblings(".item-content").stop(true, true).slideUp(500);
            theDiv = $(this);
            $(".item-content").attr("data-sign", "0");
            $(".item-title").addClass("item-title-arrow");
            $(this).removeClass("item-title-arrowUp");
        }
        // setTimeout(function () {
        //     ItemScrollTop = theDiv.offset().top - 50;
        //     $("html,body").animate({ "scrollTop": ItemScrollTop }, 500);
        // }, 600);
    });

    $(".item").each(function (index, element) {
        var item_content = $(this).find(".item-content");
        if (item_content) {
            var sign1 = $(item_content).attr("data-sign");
            if (sign1 == 1) {
                $(item_content).show();
            }
            else {
                $(item_content).hide();
            }
        }

        $(this).find("img").each(function (index, element) {
            var theWidth = $(this).width();
            var windowWidth = $(".bodyBlock").width();
            if (theWidth == 0 || theWidth > windowWidth) {
                $(this).css("width", "100%");
                $(this).attr("height", "");
            }
        });
    });

    //$('.item-title:first').removeClass('item-title-arrow');
    //$('.item-content:first').css('display','block').attr('data-sign',1);
});