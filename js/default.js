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

  var orderTypeRowTotal = function(orderTypeRow){
    var orderTypeRow = jQuery('.order-type-row');
    var orderSubTotal = 0.00;
    var orderTotal = 0.00;
    var orderDelivery = parseFloat(jQuery('.order-frete-value').val().replace(',', '.'));
    orderTypeRow.each(function(i, e){
      var orderTypeValue = jQuery(e).find('.input-order-type-value').val().replace(',','.');
      var orderTypeAmount = jQuery(e).find('.input-order-type-amount').val();
      orderSubTotal = orderTypeValue * orderTypeAmount;
      orderTotal = orderTotal + orderSubTotal;
      jQuery(e).find('.input-order-type-total').val(orderSubTotal.toFixed(2).toString().replace('.',',')).mask("#.##0,00", {reverse: true});
    });
    orderTotal = orderTotal + orderDelivery;
    jQuery('.input-order-total').val(orderTotal.toFixed(2).toString().replace('.',',')).mask("#.##0,00", {reverse: true});
    orderTypeRow = null;
  }

  jQuery(document).on('blur', '.input-order-type-amount', orderTypeRowTotal);
  jQuery(document).on('blur', '.input-order-type-value', orderTypeRowTotal);
  jQuery(document).on('blur', '.order-frete-value', orderTypeRowTotal);

  jQuery('.btn-add-order-type').on('click', function(){
    var newRow = jQuery('#order-type-container .order-type-row').first().clone();
    newRow.appendTo('#order-type-container').
      find('.btn-add-order-type').removeClass('btn-success btn-add-order-type').addClass('btn-warning btn-remove-order-type').
      find('.glyphicon').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    var inputField = newRow.find('input');
    jQuery(inputField).each(function(element){
      jQuery(this).attr('name', jQuery(this).attr('name') + '-' + i);
    });
    var selectField = newRow.find('select');
    jQuery(selectField).each(function(element){
      jQuery(this).attr('name', jQuery(this).attr('name') + '-' + i);
    });
    i++;
  });

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
