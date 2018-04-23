{extend name='template/layout' /}
{block name='content'}
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <button type="submit" form="form-category" data-toggle="tooltip" title="保存" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                    </button>
                    <a href="" data-toggle="tooltip" title="取消" class="btn btn-default">
                        <i class="fa fa-reply"></i>
                    </a>
                </div>
                <h1>%title%列表</h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-pencil"></i>
                        %title%编辑
                    </h3>
                </div>
                <div class="panel-body">
                    <form action="{:url('save')}" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
                        {if condition="isset($data['id'])"}
                            <input type="hidden" name="id" value="{$data['id']}" id="input_id" />
                        {/if}
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-general">
%field_list%
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/block}