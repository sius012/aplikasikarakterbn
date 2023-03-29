$(document).ready(function () {
    $(".has-tooltips").hover(
        function () {
            $(this).append(`
        <div class="custom-tooltip ">
            <div class="row-tooltip ">
                <span>${$(this).data("header")}: ${$(this).data("jumlah")} Penilai</span>
            </div>
        </div>`).show("fast");
        },
        function () {
            $(".custom-tooltip").remove();
        }
    );
});
