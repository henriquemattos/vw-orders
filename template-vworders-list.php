<div class="container-fluid">
  <h1 class="text-info">Listar Pedidos</h1>
  <div class="text-left">
    <a href="<?php menu_page_url('vw-orders-create'); ?>" class="btn btn-success">Adicionar novo pedido</a>
  </div>
  <br />
  <?php // $results is the get_results query object ?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nº do Pedido</th>
        <th>Data do Pedido</th>
        <th>Cliente</th>
        <th>CPF/CNPJ</th>
        <th colspan="2">Total R$</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="7"></th>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($results as $row) : ?>
        <tr>
          <td><?php echo $row->id; ?></td>
          <td><a href="<?php menu_page_url('vw-orders-create'); ?>&order=<?php echo $row->id; ?>"><?php echo $row->order_number; ?></a></td>
          <td><?php echo $row->order_date; ?></td>
          <td><?php echo $row->order_client; ?></td>
          <td><?php echo $row->order_cpf_cnpj; ?></td>
          <td><?php echo $row->order_total; ?></td>
          <td class="text-center">
            <button class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip" data-placement="top"><i class="glyphicon glyphicon-pencil"></i></button>
            <button class="btn btn-sm btn-warning" title="Imprimir PDF" data-toggle="tooltip" data-placement="top"><i class="glyphicon glyphicon-print"></i></button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
