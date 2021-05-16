$(document).ready(function () {
  var searchParams = new URLSearchParams(window.location.search);
  var moduleName = searchParams.get("module"); // backend
  var controllerName = searchParams.get("controller"); //

  // $('[type="checkbox"]').change(function() {

  //   console.log('message');
  //   var countCheckedInput = $('[name="checkbox[]"]:checked').length;

  //   $('#bulk-apply span.navbar-badge').html(countCheckedInput);
  //   $('#bulk-apply span.navbar-badge').css('display', 'inline');

  // })

  $('#form-table input[type="checkbox"]').change(function () {
    let checkbox = $('#form-table input[name="checkbox[]"]:checked');
    let navbarBadge = $("#bulk-apply .navbar-badge");
    if (checkbox.length > 0) {
      navbarBadge.html(checkbox.length);
      navbarBadge.css("display", "inline");
    } else {
      navbarBadge.html("");
      navbarBadge.css("display", "none");
    }
  });

  // CHECK ALL
  $("#check-all").click(function () {
    $("input:checkbox").not(this).prop("checked", this.checked);
  });

  // EVENT CLICK: CHECK ALL CHECKBOX
  // $("#check-all").click(function () {
  //   $("input:checkbox").not(this).prop("checked", this.checked);
  // });

  // BULK-APPLY
  $("#bulk-apply").click(function () {
    var action = $("#bulk-action").val(); // multi active

    var link = `index.php?module=${moduleName}&controller=${controllerName}&action=${action}`;
    //var link = 'index.php?module='+THEME_DATA.moduleName+'&controller='+ THEME_DATA.controllerName+'&action='+action;

    var countCheckedInput = $('[name="checkbox[]"]:checked').length;
    if (countCheckedInput > 0) {
      confirmBulkAction(link, action);
    } else {
      showToast("warning", "bulk-action-not-selected-row");
    }
  });

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

  // CLICK CLEAR SEARCH
  $("button#btn-clear-search").click(function () {
    let exceptParams = ["key", "filter_search"];
    let link = createLink(exceptParams);
    window.location.href = link.slice(0, -1);
  });

  // SEARCH NAME
  $("#btn-search").click(function (e) {
    e.preventDefault();
    value = $("input[name=search_value]").val();
    valueKey = $("select[name=key]").val();
    if (value != "" && valueKey != "") {
      let exceptParams = [
        "filter_page",
        "sort_field",
        "sort_order",
        "filter_search",
        "key",
      ];
      let link = createLink(exceptParams);
      link += `key=${valueKey}&filter_search=${value}`;
      window.location.href = link; //.slice(0,-1)
    } else {
      showToast("warning", "import_content_search");
    }
  });

  // SELECT GROUP ACP
  $("#filter-bar select[name=filter_group_acp]").change(function (e) {
    e.preventDefault();
    value = $("select[name=filter_group_acp]").val(); // default || 1 || 0
    if (value != "") {
      let exceptParams = [
        "filter_page",
        "sort_field",
        "sort_order",
        "filter_group_acp",
      ];
      let link = createLink(exceptParams);
      link += `filter_group_acp=${value}`;
      window.location.href = link;
    }
  });

  
  // SELECT TRANG THAI
  $("#filter-bar select[name=filter_status]").change(function (e) {
    e.preventDefault();
    value = $("select[name=filter_status]").val(); // default || 1 || 0
    if (value != "") {
      let exceptParams = [
        "filter_page",
        "sort_field",
        "sort_order",
        "filter_status",
      ];
      let link = createLink(exceptParams);
      link += `filter_status=${value}`;
      window.location.href = link;
    }
  });

  // SELECT GROUP
  $("#filter-bar select[name=filter_group_id]").change(function (e) {
    e.preventDefault();
    value = $("select[name=filter_group_id]").val(); // default || 1 || 0
    if (value != "") {
      let exceptParams = [
        "filter_page",
        "sort_field",
        "sort_order",
        "filter_group_id",
      ];
      let link = createLink(exceptParams);
      link += `filter_group_id=${value}`;
      window.location.href = link;
    }
  });

  // SELECT GROUP LIST
  $("select[name=select-group]").change(function (e) {
    e.preventDefault();
    let value = $(this).val();
    let id = $(this).data("id");
    let url = `index.php?module=${moduleName}&controller=${controllerName}&action=ajaxChangeGroup&id=${id}&group_id=${value}`;
    var select = $(this);
    $.get(
      url,
      function (data) {
        $(".modified-" + data.id).html(data.modified);
        select.notify("Cập nhập thành công", {
          position: "top center",
          className: "success",
          autoHideDelay: 1000,
        });
      },
      "json"
    );
  });


  // SELECT STATUS -- CART
  $("select[name=select-status]").change(function (e) {
    
    e.preventDefault();
    let value = $(this).val();
    let id = $(this).data("id");
    let url = `index.php?module=${moduleName}&controller=${controllerName}&action=ajaxChangeStatus&id=${id}&status=${value}`;
    var select = $(this);
    $.get(
      url,
      function (data) {
        //$(".modified-" + data.id).html(data.modified);
        select.notify("Cập nhập thành công", {
          position: "top center",
          className: "success",
          autoHideDelay: 1000,
        });
      },
      "json"
    );
  });





  // Switch GroupACP Change Event
  $("input.chkGroupACP").each(function () {
    $(this).change(function () {
      let checkbox = $(this);
      let url = $(this).data("url");
      $.get(
        url,
        function (data) {
          $(".modified-" + data.id).html(data.modified);
          checkbox.data("url", data.link);
          showToast("success", "update");
        },
        "json"
      );
    });
  });

  // ORDERING
  $(".chkOrdering").change(function () {
    var chkOrdering = $(this);
    let ordering = $(this).val();
    let id = $(this).data("id");
    let url = `index.php?module=${moduleName}&controller=${controllerName}&action=ajaxOrdering&id=${id}&ordering=${ordering}`;

    $.get(
      url,
      function (data) {
        $(".modified-" + data.id).html(data.modified);
        chkOrdering.notify("Cập nhập thành công", {
          position: "top center",
          className: "success",
          autoHideDelay: 1000,
        });
      },
      "json"
    );
  });

  $(".btn-delete-item").click(function (e) {
    e.preventDefault();
    var btnDelete = $(this);
    Swal.fire(
      confirmObj("Bạn chắc chắn muốn xóa dòng dữ liệu này?", "error", "Xóa")
    ).then((result) => {
      if (result.value) {
        window.location.href = btnDelete.attr("href");
      }
    });
  });

  $("#filter-bar select[name=filter_category_id]").change(function () {
    $("#filter-bar").submit();
  });

  
});

// CONFIRM OBJ VI TRI
function confirmObj(text, icon, confirmText) {
  return {
    position: "top",
    title: "Thông báo!",
    text: text,
    icon: icon,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: confirmText,
    cancelButtonText: "Hủy",
  };
}

// SHOW CONFIRM BULK
function confirmBulkAction(link, action) {
  var obj = "";
  switch (action) {
    case "delete":
      obj = confirmObj("Xóa các dòng dữ liệu đã chọn?", "error", "Xóa");
      break;
    case "active":
      obj = confirmObj("Kích hoạt các dòng dữ liệu đã chọn?", "info", "Đồng ý");
      break;
    case "inactive":
      obj = confirmObj(
        "Bỏ kích hoạt các dòng dữ liệu đã chọn?",
        "info",
        "Đồng ý"
      );
      break;
    default:
      showToast("warning", "bulk-action-not-selected-action");
      return;
  }

  Swal.fire(obj).then((result) => {
    if (result.value) {
      console.log(result);
      $("#form-table").attr("action", link);
      $("#form-table").submit();
    }
  });
}

// TOAST VI TRI
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timerProgressBar: true,
  timer: 5000,
  padding: "1rem",
});

// SHOW TOAST
function showToast(type, action) {
  let message = "";
  switch (action) {
    case "update":
      message = "Cập nhật thành công !";
      break;
    case "updateError":
      message = "Cập nhật thất bại !";
      break;
    case "deleteSuccess":
      message = "Xoá dữ liệu thành công !";
      break;
    case "deleteError":
      message = "Xoá dữ liệu thất bại !";
      break;
    case "reset_pas_success":
      message = "Reset password thành công !";
      break;
    case "reset_pas_error":
      message = "Reset password thất bại !";
      break;
    case "addDataSuccess":
      message = "Thêm dữ liệu thành công !";
      break;
    case "addDataError":
      message = "Thêm dữ liệu thất bại !";
      break;
    case "editDataSuccess":
      message = "Chỉnh sửa dữ liệu thành công !";
      break;
    case "editDataError":
      message = "Chỉnh sửa dữ liệu thất bại !";
      break;
    case "bulk-action-not-selected-action":
      message = "Vui lòng chọn action cần thực hiện !";
      break;
    case "bulk-action-not-selected-row":
      message = "Vui lòng chọn ít nhất 1 dòng dữ liệu !";
      break;
    case "import_content_search":
      message = "Nhập nội dung cần tìm kiếm !";
      break;
  }
  Toast.fire({
    icon: type,
    title: " " + message,
  });
}

// CHANGE STATUS
function changeStatus(url) {
  console.log(url);
  $.get(
    url,
    function (data) {
      element = "a.status-" + data.id;
      if (data.status == 1) {
        $(element).removeClass("btn-danger").addClass("btn-success");
        $(element).find("i").attr("class", "fas fa-check");
      }
      if (data.status == 0) {
        $(element).removeClass("btn-success").addClass("btn-danger");
        $(element).find("i").attr("class", "fas fa-minus");
      }
      var btnStatus = $(element);
      btnStatus.notify("Cập nhập thành công", {
        position: "top center",
        className: "success",
        autoHideDelay: 1000,
      });
      $(".modified-" + data.id).html(data.modified);
      $(element).attr("href", "javascript:changeStatus('" + data.link + "')");
    },
    "json"
  );
}

// CHANGE SPECIAL
function changeSpecial(url) {
  console.log(url);
  $.get(
    url,
    function (data) {
      element = "a.special-" + data.id;
      if (data.special == 1) {
        $(element).removeClass("btn-danger").addClass("btn-success");
        $(element).find("i").attr("class", "fas fa-check");
      }
      if (data.special == 0) {
        $(element).removeClass("btn-success").addClass("btn-danger");
        $(element).find("i").attr("class", "fas fa-minus");
      }
      var btnStatus = $(element);
      btnStatus.notify("Cập nhập thành công", {
        position: "top center",
        className: "success",
        autoHideDelay: 1000,
      });
      $(".modified-" + data.id).html(data.modified);
      $(element).attr("href", "javascript:changeSpecial('" + data.link + "')");
    },
    "json"
  );
}

// CHANGE GROUP ACP
function changeGroupACP(url) {
  $.get(
    url,
    function (data) {
      element = "a.groupACP-" + data.id;
      if (data.group_acp == 1) {
        $(element).removeClass("btn-danger").addClass("btn-success");
        $(element).find("i").attr("class", "fas fa-check");
      }
      if (data.group_acp == 0) {
        $(element).removeClass("btn-success").addClass("btn-danger");
        $(element).find("i").attr("class", "fas fa-minus");
      }
      var btnStatus = $(element);
      btnStatus.notify("Cập nhập thành công", {
        position: "top center",
        className: "success",
        autoHideDelay: 1000,
      });
      $(".modified-" + data.id).html(data.modified);

      $(element).attr("href", "javascript:changeGroupACP('" + data.link + "')");
    },
    "json"
  );
}

// SUBMIT FORM
function submitForm(url) {
  $("#admin-form").attr("action", url);
  $("#admin-form").submit();
}

// SORT LIST
function sortList(col, order) {
  $("input[name=filter_column]").val(col);
  $("input[name=filter_column_dir]").val(order);
  $("#form-table").submit();
}


// RANDOM STRING
function randomString(length = 12) {
  var characters = Array.from(
    "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz"
  );
  characters.sort(() => Math.random() - 0.5);
  characters = characters.join("");
  var result = characters.substring(0, length);
  return result;
}

$(".btn-generate-password").click(function () {
  $('input[name="new-password"]').val(randomString());
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#blah").attr("src", e.target.result).show();
    };
    reader.readAsDataURL(input.files[0]);
  }
}

$('select[name="select-category"]').change(function () {
  $currentSelectCategory = $(this);
  let category = $(this).val();
  let url = $(this).data("url");
  url = url.replace("value_new", category);
  $.get(
    url,
    function (data) {
      //$(".modified-" + data.id).html(data.modified);
      $currentSelectCategory.notify("Cập nhập thành công", {
        position: "top center",
        className: "success",
        autoHideDelay: 1000,
      });
    },
    "json"
  );
});

// MULTIPLE IMAGES PREVIEW IN BROWSER
$(function() {
  
  var imagesPreview = function(input, placeToInsertImagePreview) {

      if (input.files) {
          var filesAmount = input.files.length;
          for (i = 0; i < filesAmount; i++) {
              var reader = new FileReader();
              reader.onload = function(event) {
                  $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
              }
              reader.readAsDataURL(input.files[i]);
          }
      }
  };

  $('#gallery-photo-add').on('change', function() {
      imagesPreview(this, 'div.gallery');
  });
});
