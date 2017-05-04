<div class="container-fluid">
  <h1 class="text-info">Listar Pedidos</h1>
  <div class="text-left">
    <a href="/wp-admin/admin.php?page=vw-orders-create" class="btn btn-success">Adicionar novo pedido</a>
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
          <td><?php echo $row->order_number; ?></td>
          <td><?php echo $row->order_date; ?></td>
          <td><?php echo $row->order_client; ?></td>
          <td><?php echo $row->order_cpf_cnpj; ?></td>
          <td><?php echo $row->order_total; ?></td>
          <td class="text-center"><button class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></button>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
