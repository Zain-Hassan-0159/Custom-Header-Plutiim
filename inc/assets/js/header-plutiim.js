jQuery(document).ready(function ($) {
    const primaryHeader = $("#primary_header");
    const hiddenNavWrapper = primaryHeader.find(".hidden_nav_wrapper");
    const buttonNormal = primaryHeader.find("button.normal");
    const buttonClose = primaryHeader.find("button.close");
    const hiddenNavParentsLi = primaryHeader.find(".hidden_nav .parents li");
    const hiddenNavChildsLi = primaryHeader.find(".hidden_nav .childs li");
    const hiddenNavChilds = primaryHeader.find(".hidden_nav .childs");
    const backwardText = primaryHeader.find(".backward a .text");
    const backward = primaryHeader.find(".backward");



    buttonNormal.on("click", function () {
        $(this).addClass("d-none");
        primaryHeader.addClass("menu_open");
        hiddenNavWrapper.addClass("menu_open");
        buttonClose.removeClass("d-none");
        hiddenNavWrapper.removeClass("d-none");
		$("body").addClass("menu-open");

    });

    buttonClose.on("click", function () {
        $(this).addClass("d-none");
        $(".menu_open").removeClass("menu_open");
        buttonNormal.removeClass("d-none");
        hiddenNavWrapper.addClass("d-none");
		$("body").removeClass("menu-open");
    });

    hiddenNavParentsLi.on("click", function () {
		if($(this).find("span.sup").length !== 0){
			const childSelector = $(this).data("target");
			hiddenNavParentsLi.removeClass('active');
			hiddenNavChildsLi.addClass('d-none');
			hiddenNavChilds.removeClass('d-none');
			backwardText.html($(this).find('a .title').text());
			backward.removeClass('d-none');
			$(this).addClass('active');
			$(`.hidden_nav .childs .${childSelector}`).removeClass('d-none');
		}
    });

    backward.on("click", function () {
        hiddenNavParentsLi.removeClass('active');
        hiddenNavChilds.addClass('d-none');
        backward.addClass('d-none');
    });
});