<!-- Main Content -->
<form action="{{ $list_action }}" method="get" class="tblist-form js-tblist-default" autocomplete="off" id="subjectcategories_tblist_form">
    <div class="row form-inline tblist-form-toolbar" >
        <div class="col-sm-9">
            <div class="form-group">
                <label class="sr-only" for="input_subject_code">{{ lang('subjectcategory/attributes.labels.subject_category_code') }}</label>
                <input type="text" name="subject_code" class="form-control" placeholder="{{ lang('subjectcategory/attributes.placeholders.subject_category_code') }}" value="{{ Input::get('subject_category_code') }}" style="width:180px">
            </div>
            <div class="form-group">
                <label class="sr-only" for="input_subject_code">{{ lang('subjectcategory/attributes.labels.subject_category_name') }}</label>
                <input type="text" name="subject_code" class="form-control" placeholder="{{ lang('subjectcategory/attributes.placeholders.subject_category_name') }}" value="{{ Input::get('subject_category_name') }}" style="width:180px">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <button type="reset" class="btn btn-info"><i class="fa fa-times"></i> {{ lang('texts.reset_button') }}</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {{ lang('texts.filter_button') }}</button>
            </div>
        </div>
    </div><!-- /.row -->


    {{ $list->getTableData() }}

    <div class="row form-inline tblist-form-toolbar" >

        <div class="col-sm-5">
            <!-- Buck Actions -->
            <div class="bulk_actions">
                <div class="form-group">
                    <select id="action_bulk" name="action" class="form-control">
                        <option value="-1">{{ lang('texts.bulk_action') }}</option>
                        <option value="delete">{{ lang('texts.delete_action') }}</option>
                        <option value="export">{{ lang('texts.export_action') }}</option>
                    </select>
                </div><!-- /.bulk_actions (Buck Actions) -->
                <button type="button" class="btn btn-primary buck_action_btn">
                    <span>{{ lang('texts.apply_button') }}</span>
                </button>
            </div>
        </div>

        <div class="col-sm-7">
            <div class="pull-right">
                {{ $list->getPaginationInfo() }}
                {{ $list->getPerPageLimit() }}
            </div>
        </div>
    </div><!-- /.row -->

    <div class="row">
        <div class="col-sm-12 center-sm">
            {{ $list->getPagination() }}
        </div>
    </div>

</form>
<script>
    $(function(){
        var $tblist = $('#subjectcategories_tblist_form');

        var $backAction = new utils.buckAction();
        $backAction.init($tblist,function(actionData)
        {
            if (actionData.total > 0)
            {
                switch (actionData.action)
                {
                    case 'delete':
                        bootbox.confirm('{{ lang("subjectcategory::texts.delete_confirmation_many") }}', function(result) {
                            if (result === true)
                            {
                                utils.redirect(utils.adminUrl('/subjectcategories/delete'+actionData.param));
                            }
                        });
                        break;
                    case 'export':
                        utils.newTab(utils.adminUrl('/subjectcategories/export'+actionData.param));
                        break;
                }
            }
            else
            {
                bootbox.alert("{{ lang('texts.no_selected_item') }}");
            }
        });
    });
</script>