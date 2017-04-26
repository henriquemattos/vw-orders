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
    <hr />
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
        <input type="text" class="form-control" id="order-zip" name="order-zip" maxlength="9">
      </div>
    </div>
    <div class="form-group">
      <label for="order-address" class="col-sm-2 control-label">Endereço Completo:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="order-address" name="order-address">
      </div>
    </div>
    <div class="form-group">
      <label for="order-email" class="col-sm-2 control-label">E-mail:</label>
      <div class="col-sm-4">
        <input type="email" class="form-control" id="order-email" name="order-email">
      </div>
    </div>
    <div class="form-group">
      <label for="order-phone" class="col-sm-2 control-label">Telefone:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="order-phone" name="order-phone">
      </div>
    </div>
    <div class="form-group">
      <label for="order-mobile" class="col-sm-2 control-label">Celular:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="order-mobile" name="order-mobile">
      </div>
    </div>
    <hr />
    <div id="order-type-container">
      <div class="form-group order-type-row">
        <label for="order-type" class="col-sm-2 control-label">Tipo de Copo:</label>
        <div class="col-sm-2">
          <select name="order-type" class="form-control">
            <option value="">Escolha um modelo</option>
            <option value="Caldereta">Caldereta</option>
            <option value="Long Drink">Long Drink</option>
            <option value="Outro">Outro</option>
          </select>
        </div>
        <div class="col-sm-2">
          <select name="order-type-color" class="form-control">
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
        </div>
        <div class="col-sm-1">
          <input type="number" class="form-control input-order-type-amount" min="1" max="9999" name="order-type-amount" value="1">
        </div>
        <div class="col-sm-2">
          <div class="input-group">
            <span class="input-group-addon">
              R$
            </span>
            <input type="text" name="order-type-value" class="form-control input-currency input-order-type-value" value="0,00" data-toggle="tooltip" data-placement="top" title="Valor unitário">
          </div>
        </div>
        <div class="col-sm-2">
          <div class="input-group">
            <span class="input-group-addon">
              R$
            </span>
            <input type="text" name="order-type-total" class="form-control input-currency input-order-type-total" value="0,00" data-toggle="tooltip" data-placement="top" title="Valor total" readonly>
          </div>
        </div>
        <div class="col-sm-1">
          <button type="button" class="btn btn-success btn-sm btn-add-order-type"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        </div>
      </div>
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
    <hr />
    <div class="form-group">
      <label for="order-extra-costs" class="col-sm-2 control-label">Custos Adicionais:</label>
      <div class="col-sm-3">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="order-tinta-dourada" value="Y"> Tinta Dourada
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="order-tinta-preta" value="Y"> Tinta Prata
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="order-fotolito-tela-pequena" value="Y"> Fotolito/Tela R$15
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="order-fotolito-tela-grande" value="Y"> Fotolito/Tela R$25
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="order-frete" id="order-frete" value="Y"> Frete
          </label>
        </div>
        <div class="checkbox input-group">
          <span class="input-group-addon">
            R$
          </span>
          <input type="text" class="form-control input-currency order-frete-value" name="order-frete-value" value="0,00">
        </div>
      </div>
    </div>
    <hr />
    <div class="form-group">
      <label for="order-total" class="col-sm-2 control-label">Total:</label>
      <div class="col-sm-2">
        <div class="input-group">
          <span class="input-group-addon">
            R$
          </span>
          <input type="text" class="form-control input-currency input-order-total" name="order-total" value="0,00">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="order-days-payment" class="col-sm-2 control-label">Dias para Pagamento:</label>
      <div class="col-sm-2">
        <input type="number" class="form-control" min="1" max="9999" name="order-days-payment" value="1">
      </div>
    </div>
    <div class="form-group">
      <label for="order-date-payment" class="col-sm-2 control-label">Data do Vencimento:</label>
      <div class="col-sm-2">
        <input type="date" class="form-control input-date" id="order-date-payment" name="order-date-payment" value="<?php echo date('d/m/Y',  time() + (86400 * 3)); ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="order-payment-method" class="col-sm-2 control-label">Forma de Pagamento:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="order-payment-method">
      </div>
    </div>
    <div class="form-group">
      <label for="order-payment-value" class="col-sm-2 control-label">Valor:</label>
      <div class="col-sm-3">
        <div class="input-group">
          <span class="input-group-addon">
            R$
          </span>
          <input type="text" name="order-payment-value" class="form-control input-currency" value="0,00">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="order-payment-notes" class="col-sm-2 control-label">Observações:</label>
      <div class="col-sm-5">
        <textarea class="form-control" name="order-payment-notes" rows="3"></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-success">Cadastrar Pedido</button>
      </div>
    </div>
  </form>
</div>
