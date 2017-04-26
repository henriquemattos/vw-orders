<div class="container-fluid">
  <h1 class="text-info">Pedidos</h1>
  <form class="form-horizontal">
    <div class="form-group">
      <label for="order-number" class="col-sm-2 control-label">Número de Venda:</label>
      <div class="col-sm-3">
        <input type="number" class="form-control" id="order-number" name="order-number" value="1" min="000000001" max="999999999">
      </div>
    </div>
    <div class="form-group">
      <label for="order-date" class="col-sm-2 control-label">Data:</label>
      <div class="col-sm-2">
        <input type="date" class="form-control input-date" id="order-date" name="order-date" value="<?php echo date('d/m/Y'); ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="order-client" class="col-sm-2 control-label">Cliente:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="order-client" name="order-client" placeholder="Cliente">
      </div>
    </div>
    <div class="form-group">
      <label for="order-cpf-cnpj" class="col-sm-2 control-label">CPF/CNPJ:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="order-cpf-cnpj" name="order-cpf-cnpj">
      </div>
    </div>
    <div class="form-group">
      <label for="order-zip" class="col-sm-2 control-label">CEP:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="order-zip" name="order-zip" maxlength="9" placeholder="22000-222">
      </div>
    </div>
    <div class="form-group">
      <label for="order-address" class="col-sm-2 control-label">Endereço Completo:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="order-address" name="order-address" placeholder="Av. Paranapuã, 262, A, Ilha do Governador, Rio de Janeiro - RJ">
      </div>
    </div>
    <div class="form-group">
      <label for="order-email" class="col-sm-2 control-label">E-mail:</label>
      <div class="col-sm-4">
        <input type="email" class="form-control" id="order-email" name="order-email" placeholder="email@dominio.com.br">
      </div>
    </div>
    <div class="form-group">
      <label for="order-phone" class="col-sm-2 control-label">Telefone:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="order-phone" name="order-phone" placeholder="(21) 2200-0022">
      </div>
    </div>
    <div class="form-group">
      <label for="order-mobile" class="col-sm-2 control-label">Celular:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="order-mobile" name="order-mobile" placeholder="(21) 98800-0088">
      </div>
    </div>
    <div class="table-responsive">
      <h3>Itens da Venda</h3>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Tipo de Copo</th>
            <th>Cor</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th colspan="2">Valor Total</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="2">Total</td>
            <td class="text-right order-type-total-amount"></td>
            <td></td>
            <td colspan="2" class="text-right">
              <div class="input-group">
                <span class="input-group-addon">
                  R$
                </span>
                <input type="text" class="form-control input-currency input-order-total" name="order-total" value="0,00">
              </div>
            </td>
          </tr>
        </tfoot>
        <tbody class="table-order-type">
          <tr>
            <td>
              <select name="order-type[]" class="form-control select-order-type">
                <option value="">Escolha um item</option>
                <optgroup label="Modelos de Copos">
                  <option value="Caldereta">Caldereta</option>
                  <option value="Long Drink">Long Drink</option>
                  <option value="Outro">Outro</option>
                </optgroup>
                <optgroup label="Custos Adicionais">
                  <option value="Tinta Dourada">Tinta Dourada</option>
                  <option value="Tinta Prata">Tinta Prata</option>
                  <option value="Fotolito/Tela">Fotolito/Tela</option>
                  <option value="Frete">Frete</option>
                </optgroup
              </select>
            </td>
            <td>
              <select name="order-type-color[]" class="form-control select-order-type-color">
                  <option value="">Escolha uma cor</option>
                  <option value="Amarelo Neon">Amarelo Neon</option>
                  <option value="Rosa Neon">Rosa Neon</option>
                  <option value="Laranja Neon">Laranja Neon</option>
                  <option value="Verde Neon">Verde Neon</option>
                  <option value="Azul Neon">Azul Neon</option>
                  <option value="Azul Bic">Azul Bic</option>
                  <option value="Vermelho Cristal">Vermelho Cristal</option>
                  <option value="Cristal">Cristal</option>
                  <option value="Branco">Branco</option>
                  <option value="Preto">Preto</option>
                  <option value="Rosa Sólido">Rosa Sólido</option>
                  <option value="Amarelo Sólido">Amarelo Sólido</option>
                  <option value="Laranja Sólido">Laranja Sólido</option>
                  <option value="Azul Sólido">Azul Sólido</option>
                  <option value="Outra Cor">Outra Cor</option>
              </select>
            </td>
            <td>
              <input type="number" name="order-type-amount[]" class="form-control input-order-type-amount" min="1" max="9999" value="1">
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon">
                  R$
                </span>
                <input type="text" name="order-type-value[]" class="form-control input-currency input-order-type-value" value="0,00" data-toggle="tooltip" data-placement="top" title="Valor unitário">
              </div>
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon">
                  R$
                </span>
                <input type="text" name="order-type-total[]" class="form-control input-currency input-order-type-total" value="0,00" data-toggle="tooltip" data-placement="top" title="Valor total" readonly>
              </div>
            </td>
            <td>
              <button type="button" class="btn btn-success btn-sm btn-add-order-type"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="table-responsive">
      <h3>Formas de Pagamento</h3>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th data-toggle="tooltip" data-placement="top" title="Dias para Pagamento">Dias p/ Pgto</th>
            <th>Data do Vencimento</th>
            <th>Forma</th>
            <th>Valor</th>
            <th>Observações</th>
          </tr>
        </thead>
        <tfoot>
          <tr><td colspan="5">&nbsp;</td></tr>
        </tfoot>
        <tbody>
          <tr>
            <td>
              <input type="number" class="form-control" min="1" max="9999" name="order-days-payment" value="1">
            </td>
            <td>
              <input type="date" class="form-control input-date" id="order-date-payment" name="order-date-payment" value="<?php echo date('d/m/Y',  time() + (86400 * 3)); ?>">
            </td>
            <td>
              <input type="text" class="form-control" name="order-payment-method">
            </td>
            <td>
              <div class="input-group">
                <span class="input-group-addon">
                  R$
                </span>
                <input type="text" name="order-payment-value" class="form-control input-currency" value="0,00">
              </div>
            </td>
            <td>
              <textarea class="form-control" name="order-payment-notes" rows="2"></textarea>
            </td>
          </tr>
            <tr>
              <td>
                <input type="number" class="form-control" min="1" max="9999" name="order-days-payment" value="1">
              </td>
              <td>
                <input type="date" class="form-control input-date" id="order-date-payment" name="order-date-payment" value="<?php echo date('d/m/Y',  time() + (86400 * 3)); ?>">
              </td>
              <td>
                <input type="text" class="form-control" name="order-payment-method">
              </td>
              <td>
                <div class="input-group">
                  <span class="input-group-addon">
                    R$
                  </span>
                  <input type="text" name="order-payment-value" class="form-control input-currency" value="0,00">
                </div>
              </td>
              <td>
                <textarea class="form-control" name="order-payment-notes" rows="2"></textarea>
              </td>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="form-group">
      <label for="order-print-color" class="col-sm-2 control-label">Cor da Impressão:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="order-print-color" name="order-print-color">
      </div>
    </div>
    <div class="form-group">
      <label for="order-date-delivery" class="col-sm-2 control-label">Data da Entrega:</label>
      <div class="col-sm-2">
        <input type="date" class="form-control input-date" id="order-date-delivery" name="order-date-delivery" value="<?php echo date('d/m/Y',  time() + (86400 * 2)); ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="order-print-color" class="col-sm-2 control-label">Transportador:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="order-delivery-name">
      </div>
    </div>
    <div class="form-group">
      <label for="order-print-color" class="col-sm-2 control-label">Modalidade:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="order-delivery-type">
      </div>
    </div>
    <div class="form-group">
      <label for="order-payment-notes" class="col-sm-2 control-label">Observações:</label>
      <div class="col-sm-5">
        <textarea class="form-control" name="order-payment-notes" rows="3">WhatsApp (21) 9703­9-9948 ­ www.querocopo.com.br</textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-success">Cadastrar Pedido</button>
      </div>
    </div>
  </form>
</div>
