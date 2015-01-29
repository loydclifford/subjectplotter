
<!-- Main Content -->
<form action="{{ $list_action }}" method="get" class="tblist-form js-tblist-default" autocomplete="off" id="rooms_tblist_form">
    <div class="row form-inline tblist-form-toolbar" >
        <div class="col-sm-9">
            <div class="form-group">
                <label class="sr-only" for="input_room_id">{{ lang('room/attributes.labels.room_id') }}</label>
                <input type="text" name="room_id" class="form-control" placeholder="{{ lang('room/attributes.placeholders.room_id') }}" value="{{ Input::get('room_id') }}" style="width:180px">
            </div>
            <div class="form-group">
                <label class="sr-only" for="input_description">{{ lang('room/attributes.labels.description') }}</label>
                <input type="text" name="description" class="form-control" id="input_description" placeholder="{{ lang('room/attributes.placeholders.description') }}" value="{{ Input::get('description') }}">
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
                <button type="button" class="btn btn-default buck_action_btn">
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
        var $tblist = $('#rooms_tblist_form');

        var $backAction = new utils.buckAction();
        $backAction.init($tblist,function(actionData)
        {
            if (actionData.total > 0)
            {
                switch (actionData.action)
                {
                    case 'delete':
                        bootbox.confirm('{{ lang("room::texts.delete_confirmation_many") }}', function(result) {
                            if (result === true)
                            {
                                utils.redirect(utils.adminUrl('/rooms/delete'+actionData.param));
                            }
                        });
                        break;
                    case 'export':
                        utils.newTab(utils.adminUrl('/rooms/export'+actionData.param));
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