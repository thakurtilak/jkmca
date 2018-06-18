<div class="remove-fields">
<?php if($type == 'salary'): ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Amount of income</label>
            <input class="ims_form_control" type="text" name="income_amount" id="income_amount" placeholder="Amount of income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Employer detail</label>
            <input class="ims_form_control" type="text" name="employer" id="employer" placeholder="Employer">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Allowance</label>
            <input class="ims_form_control" type="text" name="allowance" id="allowance" placeholder="Allowance">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
<?php endif; ?>

<?php if($type == 'HP'): ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Amount of income</label>
            <input class="ims_form_control" type="text" name="income_amount[]" id="income_amount" placeholder="Amount of income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Property Add</label>
            <input class="ims_form_control" type="text" name="property_add" id="property_add" placeholder="Property">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
<?php endif; ?>



<?php if($type == 'BI'): ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Amount of income</label>
            <input class="ims_form_control" type="text" name="income_amount[]" id="income_amount" placeholder="Amount of income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Turnover</label>
            <input class="ims_form_control" type="text" name="turnover" id="turnover" placeholder="Turnover">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Purchase</label>
            <input class="ims_form_control" type="text" name="purchase" id="purchase" placeholder="Purchase">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Stock</label>
            <input class="ims_form_control" type="text" name="stock" id="stock" placeholder="Stock">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Loans</label>
            <input class="ims_form_control" type="text" name="loans" id="loans" placeholder="Loans">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Debtors</label>
            <input class="ims_form_control" type="text" name="debtors" id="debtors" placeholder="Debtors">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Creditors</label>
            <input class="ims_form_control" type="text" name="creditors" id="creditors" placeholder="Creditors">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Cash/Bank</label>
            <input class="ims_form_control" type="text" name="cash" id="cash" placeholder="Cash/Bank">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
<?php endif; ?>

    <?php if($type == 'CG'): ?>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="ims_form_label">Amount of income</label>
                <input class="ims_form_control" type="text" name="income_amount[]" id="income_amount" placeholder="Amount of income">
                <label class="error" style="display:none;">Required</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="ims_form_label">Property sale value</label>
                <input class="ims_form_control" type="text" name="property_sale_value" id="property_sale_value" placeholder="Property Sale Value">
                <label class="error" style="display:none;">Required</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="ims_form_label">Sale Date</label>
                <input class="ims_form_control" type="text" name="sale_date" id="sale_date" placeholder="Sale Date">
                <label class="error" style="display:none;">Required</label>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label class="ims_form_label">Cost Of improvement</label>
                <input class="ims_form_control" type="text" name="c_improvement" id="c_improvement" placeholder="Cost Of improvement">
                <label class="error" style="display:none;">Required</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="ims_form_label">Purchase Value</label>
                <input class="ims_form_control" type="text" name="purchase_value" id="purchase_value" placeholder="Purchase Value">
                <label class="error" style="display:none;">Required</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="ims_form_label">Purchase Date</label>
                <input class="ims_form_control" type="text" name="purchase_date" id="purchase_date" placeholder="Purchase Date">
                <label class="error" style="display:none;">Required</label>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label class="ims_form_label">Capital Gain/Lose</label>
                <input class="ims_form_control" type="text" name="capital_gain_loss" id="capital_gain_loss" placeholder="Capital Gain/Loss">
                <label class="error" style="display:none;">Required</label>
            </div>
        </div>
    <?php endif; ?>

<?php if($type == 'Other'): ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Amount of income</label>
            <input class="ims_form_control" type="text" name="income_amount" id="income_amount" placeholder="Amount of income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Bank Inst.</label>
            <input class="ims_form_control" type="text" name="bank_inst" id="bank_inst" placeholder="Bank Inst.">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">FD</label>
            <input class="ims_form_control" type="text" name="fd" id="fd" placeholder="FD">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Agent Income</label>
            <input class="ims_form_control" type="text" name="agent_income" id="agent_income" placeholder="Agent Income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
<?php endif; ?>

<?php if($type == 'Agriculture'): ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Amount of income</label>
            <input class="ims_form_control" type="text" name="income_amount" id="income_amount" placeholder="Amount of income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Land Acre</label>
            <input class="ims_form_control" type="text" name="land_acre" id="land_acre" placeholder="Land Acre">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
<?php endif; ?>
</div>
