// thumbnail sort selection
function sort_go_page (sbd) {
	wloc = 'thumbnails.php?album='
	+ js_vars.sort_vars.aid
	+ '&page='
	+ js_vars.sort_vars.page
	+ '&sort=' + sbd;
	window.location = wloc;
}
function sort_sel_sbd (elm) {
	sort_go_page(elm.value);
}
function sort_sel_val (elm) {
	sort_go_page(elm.value + js_vars.h5r_sort.charAt(1));
}
function sort_sel_dir (elm) {
	sort_go_page(js_vars.h5r_sort.charAt(0) + elm.getAttribute("data-dir"));
}


// keyboard and touch/swipe navigation
var	swik_nav = (function($) {
	var blnk = null,
		plnk = null,
		nlnk = null,
		elnk = null;

	function key_nav (e) {
		var lnk = null;
		switch (e.keyCode) {
		case 37:
		case 39:
			if (e.preventDefault) e.preventDefault();
			if (e.stopPropagation) e.stopPropagation();
			if (e.keyCode == 37) {
				lnk = e.altKey ? blnk : plnk;
			} else {
				lnk = e.altKey ? elnk : nlnk;
			}
			break;
		}
		if (lnk) window.location = lnk;
	}

	return function (prm) {
		blnk = $(prm.belm).prop('href');
		plnk = $(prm.pelm).prop('href');
		nlnk = $(prm.nelm).prop('href');
		elnk = $(prm.eelm).prop('href');
		document.addEventListener("keydown", key_nav, false);
		$(prm.selm).on('swipeleft', function(){if (nlnk) window.location = nlnk});
		$(prm.selm).on('swiperight', function(){if (plnk) window.location = plnk});
	};
}(jQuery));

function useMicroModal () {
	// replace Greybox modal with MicroModal modal
	$("a.greybox").unbind('click');
	$("a.greybox").click(function(){
		$("#modal-1-title span").html(this.title || $(this).text());
		$("#mmflodr").show();
		$('#mmframe').attr("src", this.href);
		MicroModal.show('modal-1', {onClose: function(){$('#mmframe').attr("src", "");} });
	//var t = this.title || $(this).text() || this.href;
	//GB_show(t,this.href,470,600);
		return false;
	});
	$("a.greyboxfull").click(function(){
		MicroModal.show('modal-1');
	//var t = this.title || $(this).text() || this.href;
	//GB_show(t,this.href,700,800);
		return false;
	});
	MicroModal.init({awaitCloseAnimation: true});
}

$(document).ready(function() {
	useMicroModal();

	// touch/swipe & keyboard
	if (js_vars.tk_nav) {
		swik_nav(js_vars.tk_nav);
	}

    //toggle the category albums display
    $(".category_collapsed").click(function(){
        $(this).toggleClass("category_expanded").parent().parent().next(".category_body").slideToggle(400);
    });
});
