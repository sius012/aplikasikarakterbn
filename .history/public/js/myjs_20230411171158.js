(function ($) {
    $.fn.TableKuy = function (data = null) {
        this.wrapInner("<div class='tablekuy-main-cont'></div>");
        var parent = this.parent();
        if (data != null) {
            if (data.tombol != undefined) {
                parent.append("<div class='tablekuy-btn-cont'></div>");
                var btn = data.tombol.map(function (e) {
                    switch (e) {
                        case "print":
                            return `<button class='btn btn-info'><i class='fa fa-print'></i></button>`;
                            break;

                        case "pdf":
                            break;

                        case "excel":
                            break;
                        default:
                            break;
                    }
                });

                parent.find(".table-btn-cont").html(btn)
            }
        }
    };
})(jQuery);
