var i = 1;
var alert = '<div class="alert alert-dismissible fade in" role="alert">'
  + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'
  + '</div>';
jQuery(document).ready(function(){
  jQuery('[data-toggle="tooltip"]').tooltip()
  jQuery('#order-zip').mask('00000-000');
  jQuery('#order-phone').mask('(00) 0000-0000');
  jQuery('#order-mobile').mask('(00) 00000-0000');
  jQuery('.input-date').mask('00/00/0000').on('focusout', function(e){
    if(!jQuery(this).val()){
      var today = new Date();
      var month = today.getMonth() + 1;
      (month < 10) ? month = '0' + month : month;
      jQuery(this).val(today.getDate() + '/' + month + '/' + today.getFullYear());
    }
  });

  jQuery('.input-currency').mask("#.##0,00", {reverse: true}).live('change', function(e){
    if(!jQuery(this).val()){
      jQuery(this).val('0,00');
    }
  });

  // multiply every amount per unit price and update total
  // sum every amount, sum every total and update footer
  var orderTypeRowTotal = function(){
    jQuery('.table-order-type tr').each(function(i,e){
      var amount = parseInt(jQuery(e).find('.input-order-type-amount').val());
      var unitPrice = parseFloat(jQuery(e).find('.input-order-type-value').val().replace(',','.'));
      var totalPrice = amount * unitPrice;
      jQuery(e).find('.input-order-type-total').val(totalPrice.toFixed(2).toString().replace('.',','));
    });
    var totalAmount = 0;
    jQuery('.input-order-type-amount').each(function(inputIndex,inputElement){
      totalAmount = totalAmount + parseInt(jQuery(inputElement).val());
    });
    jQuery('.order-type-total-amount').html(totalAmount);
    var totalPrice  = 0.00;
    jQuery('.input-order-type-total').each(function(inputIndex,inputElement){
      totalPrice = totalPrice + parseFloat(jQuery(inputElement).val().replace(',','.'));
    });
    jQuery('.input-order-total').val(totalPrice.toFixed(2).toString().replace('.',','));
  };

  jQuery(document).on('focusout', '.input-order-type-amount', orderTypeRowTotal);
  jQuery(document).on('focusout', '.input-order-type-value', orderTypeRowTotal);
  jQuery(document).on('focusout', '.order-frete-value', orderTypeRowTotal);

  // add new table row
  jQuery('.btn-add-order-type').live('click', function(){
    var tableBody = jQuery(this).parent().parent();
    var newRow = tableBody.first().clone();
    newRow.find('.btn-add-order-type').removeClass('btn-sucess btn-add-order-type').
      addClass('btn-warning btn-remove-order-type').find('.glyphicon').removeClass('glyphicon-plus').
      addClass('glyphicon-minus');
    newRow.find('.select-order-type').val('');
    newRow.find('.select-order-type-color').val('');
    newRow.find('.input-order-type-amount').val(1);
    newRow.find('.input-order-type-value').val('0,00');
    newRow.find('.input-order-type-total').val('0,00');
    newRow.appendTo(tableBody.parent());
    orderTypeRowTotal();
  });

  // remove table row
  jQuery('.btn-remove-order-type').live('click', function(){
    jQuery(this).parent().parent().remove();
    orderTypeRowTotal();
  });

  jQuery('form').on('submit', function(e){
    e.preventDefault();
    var data = {
      'action': 'save',
      'nonce': ajax_object.nonce,
      'data': jQuery(this).serialize()
    };
    jQuery.ajax({
      url: ajax_object.ajax_url,
      data: data,
      cache: false,
      context: document.body,
      dataType: 'json',
      method: 'POST',
      beforeSend: function(jqXHR, settings){
        jQuery('.alert-dismissible').alert('close');
      },
      success: function(data, textStatus, jqXHR){
        var msg = '<p>' + textStatus + ': ' + data.response + '</p>';
        jQuery('#alert').prepend(jQuery(alert).append(msg).addClass('alert-success').alert());
      },
      complete: function(jqXHR, textStatus){
      },
      error: function(jqXHR, textStatus, errorThrown){
        var msg = '<p>' + textStatus + ': ' + errorThrown + '</p>';
        jQuery('#alert').prepend(jQuery(alert).append(msg).addClass('alert-danger').alert());
      }
    });
  });
});
