/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('.journal-detail').click(function(){
        var result = '#edit-journal section';
        var data = {
            'id':$(this).data('id')
        }
        var url = './rest/journal/journal_detail';
        $(result).html('Fetching Information');
        ajax_declare(url,data,result);
    });
});