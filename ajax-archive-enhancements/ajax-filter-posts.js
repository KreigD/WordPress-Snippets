jQuery(document).ready(function ($) {
  // Uncheck checkboxes on page load to prevent weirdness
  function UncheckAll() {
    const w = document.getElementsByTagName('input');
    for (var i = 0; i < w.length; i++) {
      if (w[i].type == 'checkbox') {
        w[i].checked = false;
      }
    }
  }

  // AJAX Post Filter scripts
  const $checkbox = $("#filter input:checkbox");

  let categoryIDs = [];

  $checkbox.change((e) => {
    let value = Number(e.currentTarget.value);

    if ($checkbox.is(':checked')) {
      categoryIDs.indexOf(value) === -1 ? (
        categoryIDs.push(value)
      ) : (
        categoryIDs = categoryIDs.filter((item) => item !== value)
      )
    } else {
      categoryIDs = [3, 4, 28, 35, 353];
    }

    categoryIDs.forEach((item) => {
      $.ajax({
        type: 'POST',
        url: afp_vars.afp_ajax_url,
        data: {
          action: "load-filter",
          category__in: categoryIDs
        },
        success: function (response) {
          $(".filter-section").empty().html(response);
          return false;
        }
      })
    });
  });

  // AJAX Load More Posts scripts
  const canBeLoaded = true;
  const bottomOffset = 1500;
  let page = 2;
  let postOffset = 9;
  let loading = false;
  const scrollHandling = {
    allow: true,
    reallow: function () {
      scrollHandling.allow = true;
    },
    delay: 400
  };

  $(window).scroll(function () {

    if (!loading && scrollHandling.allow) {
      scrollHandling.allow = false;
      setTimeout(scrollHandling.reallow, scrollHandling.delay);
      if ($(document).scrollTop() > ($(document).height() - bottomOffset) && canBeLoaded == true) {
        loading = true;
        $.ajax({
          type: 'POST',
          url: afp_vars.afp_ajax_url,
          data: {
            action: "afp_load_more",
            page: page,
            query: afp_vars.query,
            category__in: categoryIDs,
            offset: postOffset
          },
          success: function (res) {
            $(".filter-section").append(res);
            page += 1;
            postOffset += 9;
            loading = false;
          }
        })
      }
    }
  });
});