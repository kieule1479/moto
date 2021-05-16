$(document).ready(function ($) {

  
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

    // exceptParams: ['filter_page', 'sort_field', 'sort_order', 'filter_search']
    for (let pair of searchParamsEntries) {
      if (exceptParams.indexOf(pair[0]) == -1) {
        link += `${pair[0]}=${pair[1]}&`;
        // index.php?module=backend&controller=group&action=index&fiter_groupacp=1&
      }
    }
    return link;
  }

  // QUICK-VIEW
  $(".quick-view").click(function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let url = `index.php?module=frontend&controller=index&action=ajaxQuickView&id=${id}`;
    $.get(
      url,
      function (data) {
        let picture = data.picture;
        let img = `/moto/public/files/moto/${picture}`;
        let link = `index.php?module=frontend&controller=moto&action=detail&moto_id=${id}`;
        $(".moto-picture").attr("src", img);
        $(".quantity-quickview").attr("data-id", id);
        $(".moto-name").html(data.name);
        $("#quick-view .moto-price .sale-price").html(data.salePriceFormat);
        $(".moto-description").html(data.short_description);
        $("#quick-view .moto-price del").html(data.priceFormat);
        $(".btn-view-moto-detail").attr("href", link);
        $(".product-buttons").attr("data-id", id);
      },
      "json"
    );
  }); // END QUICK-VIEW



  //============================================ MUA HANG=================================================




  // ADD 1SP
  $("i.add-to-cart").click(function (e) {
    e.preventDefault();

    if (THEME_DATA.user == "") {
      link = "index.php?module=frontend&controller=user&action=login";
      window.location.href = link;
    } else {
      $currentSelectGroup = $("#cart");
      let id = $(this).data("id");
      let url = `index.php?module=frontend&controller=user&action=ajaxCart&id=${id}&sl=1`;
      $.get(
        url,
        function (data) {
          $currentSelectGroup.notify("Thêm giỏ hàng thành công!", {
            className: "success",
            position: "bottom right",
          });
          $("#badge").html(data.badge);
        },
        "json"
      );
    }
  }); // END ADD 1SP


  // ADD NHIEU SP
  $(".product-buttons a.btn-add-to-cart").click(function (e) {
    e.preventDefault();

    if (THEME_DATA.user == "") {
      link = "index.php?module=frontend&controller=user&action=login";
      window.location.href = link;
    } else {
      $currentSelectGroup = $("#cart");
      let sl = $("input[name=quantity]").val();
      let id = $(".product-buttons").data("id");
      let url = `index.php?module=frontend&controller=user&action=ajaxCart&id=${id}&sl=${sl}`;
      $.get(
        url,
        function (data) {
          $currentSelectGroup.notify("Thêm giỏ hàng thành công!", {
            className: "success",
            position: "bottom right",
          });
          $("#badge").html(data.badge);
        },
        "json"
      );
    }
  }); // END ADD NHIEU SP



  $(".product-buttons a.btn-buy").click(function (e) {

     if (THEME_DATA.user == "") {
      link = "index.php?module=frontend&controller=user&action=login";
      window.location.href = link;
    } else {
    e.preventDefault();
    $currentSelectGroup = $("#cart");
    let sl = $("input[name=quantity]").val();
    let id = $(".product-buttons").data("id");
    let url = `index.php?module=frontend&controller=user&action=ajaxCart&id=${id}&sl=${sl}`;
    $.get(
      url,
      function (data) {
        console.log(data);
        $currentSelectGroup.notify("Thêm giỏ hàng thành công!", {
          className: "success",
          position: "bottom right",
        });
        $("#badge").html(data.badge);
      },
      "json"
    );
    }
  });

  // XOA SAN PHAM
  $("i.clear").click(function (e) {
    e.preventDefault();
    $currentSelectCart = $("#cart");
    //let sl = $(".input-group input").val();
    let id = $(this).data("id");
    let url = `index.php?module=frontend&controller=user&action=ajaxDelete&id=${id}`;
    $.get(
      url,
      function (data) {
        // $currentSelectCart.notify("Xoa thành công!", {
        //   className: "success",
        //   position: "bottom right",
        // });
        // $("#badge").html(data.badge);
        link = "index.php?module=frontend&controller=user&action=cart";
        window.location.href = link;
      },
      "json"
    );
  });

  // $(document).ready(function(){
  //   $(".owl-carousel").owlCarousel();
  // });

  //chay slider
  $(".autoplay").slick({
    dots: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    
  });

  $(".container").imagesLoaded(function () {
    $("#exzoom").exzoom({
      autoPlay: true,
      navWidth: 60,
      navHeight: 60,
      navItemNum: 5,
      navItemMargin: 7,
      navBorder: 1,
    });
    $("#exzoom").removeClass("hidden");
  });
});
