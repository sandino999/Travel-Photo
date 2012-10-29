/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var ajax_declare = function (url,data,result) {
    $.post(
        url,
        data,
        function(data) {
            $(result).html(data);
        }
    );
}