/* File Created: 五月 18, 2013 */
$(function () {
    $('#Go').click(function () {
        var key = $('#search').val();
        if (key != "") {

            location.href = 'SearchNews.aspx?key=' + key;
        } else {
            alert("请输入关键字");
        }
    });
//        $('#search').focus(function () {
//            $(this).val("");
//        });
//        $('#search').blur(function () {
//            if ($(this).val() == "") {
//                $(this).val(this.defaultValue);
//            }
//        });
});
    