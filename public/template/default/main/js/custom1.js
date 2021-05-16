$(document).ready(function () {
  // CREATE LINK
  function createLink(exceptParams) {
    //http://localhost/index.php?module=backend&controller=group&action=index&fiter_groupacp=1
    let pathname = window.location.pathname; //  index.php
    let searchParams = new URLSearchParams(window.location.search); //module=backend&controller=group&action=index&fiter_groupacp=1
    let searchParamsEntries = searchParams.entries(); // la 1 mảng  // module => backend
    // controller => group
    // action => index
    // fiter_groupacp => 1
    // filter_search => 'ad'
    let link = pathname + "?"; // index.php?

    //exceptParams: ["filter_page", "sort_field", "sort_order", "filter_search"];
    for (let pair of searchParamsEntries) {
      if (exceptParams.indexOf(pair[0]) == -1) {
        link += `${pair[0]}=${pair[1]}&`;
        // index.php?module=backend&controller=group&action=index&fiter_groupacp=1&
      }
    }
    return link;
  }

  $(".slide-5").on("setPosition", function () {
    $(this).find(".slick-slide").height("auto");
    var slickTrack = $(this).find(".slick-track");
    var slickTrackHeight = $(slickTrack).height();
    $(this)
      .find(".slick-slide")
      .css("height", slickTrackHeight + "px");
    $(this)
      .find(".slick-slide > div")
      .css("height", slickTrackHeight + "px");
    $(this)
      .find(".slick-slide .category-wrapper")
      .css("height", slickTrackHeight + "px");
  });

  $(".breadcrumb-section").css("margin-top", $(".my-header").height() + "px");
  $(".my-home-slider").css("margin-top", $(".my-header").height() + "px");

  $(window).resize(function () {
    let height = $(".my-header").height();
    $(".breadcrumb-section").css("margin-top", height + "px");
    $(".my-home-slider").css("margin-top", height + "px");
  });

  // show more show less
  if ($(".category-item").length > 10) {
    $(".category-item:gt(9)").hide();
    $("#btn-view-more").show();
  }

  $("#btn-view-more").on("click", function () {
    $(".category-item:gt(9)").toggle();
    $(this).text() === "Xem thêm"
      ? $(this).text("Thu gọn")
      : $(this).text("Xem thêm");
  });

  $("li.my-layout-view > img").click(function () {
    $("li.my-layout-view").removeClass("active");
    $(this).parent().addClass("active");
  });

  // SORT
  $('#sort-form select[name="sort"]').change(function (e) {
    e.preventDefault();
    linkCu    = createLink(['sort']);
    valueSort = $("#sort option:selected").val();
    linkNew   = linkCu + "sort=" + valueSort;

    window.location.href = linkNew;

  }); // END SORT



  setTimeout(function () {
    $("#frontend-message").toggle("slow");
  }, 4000);
});

function activeMenu() {
  // let controller = getUrlParam('controller') == null ? 'index' : getUrlParam('controller');
  // let action = getUrlParam('action') == null ? 'index' : getUrlParam('action');
  let dataActive = controller + "-" + action;
  $(`a[data-active=${dataActive}]`).addClass("my-menu-link active");
}

function getUrlParam(key) {
  let searchParams = new URLSearchParams(window.location.search);
  return searchParams.get(key);
}
