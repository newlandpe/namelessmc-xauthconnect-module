{include file='header.tpl'}
{include file='sidebar.tpl'}

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="h3 mb-0 text-gray-800">{$XAUTHCONNECT_SETTINGS}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{url parameters=[] route='panel'}">{$HOME}</a></li>
                    <li class="breadcrumb-item"><a href="{url parameters=[] route='panel/integrations'}">{$INTEGRATIONS}</a></li>
                    <li class="breadcrumb-item active">{$XAUTHCONNECT_SETTINGS}</li>
                </ol>
            </div>
        </div>

        <!-- Success and Error Alerts -->
        {if isset($SUCCESS)}
            <div class="alert alert-success">{$SUCCESS}</div>
        {/if}

        {if isset($ERRORS) && count($ERRORS)}
            <div class="alert alert-danger">
                {foreach from=$ERRORS item=error}
                    {$error}<br />
                {/foreach}
            </div>
        {/if}

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="client_id">{$XAUTHCONNECT_CLIENT_ID}</label>
                        <input type="text" name="client_id" id="client_id" class="form-control" value="{$CLIENT_ID}">
                    </div>
                    <div class="form-group">
                        <label for="client_secret">{$XAUTHCONNECT_CLIENT_SECRET}</label>
                        <input type="text" name="client_secret" id="client_secret" class="form-control" value="{$CLIENT_SECRET}">
                    </div>
                    <div class="form-group">
                        <label for="issuer_url">{$XAUTHCONNECT_ISSUER_URL}</label>
                        <input type="text" name="issuer_url" id="issuer_url" class="form-control" value="{$ISSUER_URL}">
                    </div>
                    <div class="form-group">
                        <label for="redirect_uri">{$XAUTHCONNECT_REDIRECT_URI}</label>
                        <input type="text" id="redirect_uri" class="form-control" value="{$REDIRECT_URI}" readonly>
                        <small class="form-text text-muted">{$XAUTHCONNECT_REDIRECT_URI_INFO}</small>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="token" value="{$TOKEN}">
                        <input type="submit" class="btn btn-primary" value="{$SUBMIT}">
                    </div>
                </form>
            </div>
        </div>

        <!-- Debug Info (Optional) -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Debug Info</h6>
            </div>
            <div class="card-body">
                <pre>
Client ID: {$CLIENT_ID}
Issuer URL: {$ISSUER_URL}
Is Setup: {if $IS_SETUP}Yes{else}No{/if}
Is Enabled: {if $IS_ENABLED}Yes{else}No{/if}
                </pre>
            </div>
        </div>

    </div>
</div>

{include file='footer.tpl'}
