/* File Created: 五月 9, 2013 */
$("#selctpro select").change(function () {
    $.post('Ajax/getCities.ashx', { pid: $(this).val() }, function (datas) {
        var data = $.parseJSON(datas);
        var html = "市:<select>";
        if (data.length != 0) {

            for (var i = 0; i < data.length; i++) {
                html += "<option value=" + data[i].code + ">" + data[i].name + "</option>";
            }
            html += "</select>";
        }
        $("#SelectCity").empty();
        $("#SelectCity").append(html);
        var code = $("#SelectCity select").eq(0).val();

        $.post('Ajax/getCities.ashx', { cid: code }, function (areas) {

            var area = $.parseJSON(areas);
            var html = "县：<select>";
            for (var i = 0; i < area.length; i++) {
                html += "<option value=" + area[i].code + " >" + area[i].name + "</option>";
            }
            html += "</select>";
            $("#SelectArea").empty();
            $("#SelectArea").append(html);
        });
    });
});
$("#SelectCity select").change(function () {
    $.post('Ajax/getCities.ashx', { cid: $(this).val() }, function (datas) {
        var data = $.parseJSON(datas);
        var html = "市：<select>";
        for (var i = 0; i < data.length; i++) {
            html += "<option value=" + data[i].code + " >" + data[i].name + "</option>";
        }
        html += "</select>";
        $("#SelectArea").empty();
        $("#SelectArea").append(html);
    });
});
