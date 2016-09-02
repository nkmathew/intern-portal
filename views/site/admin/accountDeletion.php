<?php
/**
 * Project: Intern Portal.
 * User: nkmathew
 * Date: 03/09/2016
 * Time: 03:38
 */

use app\assets\AdminAccountAsset;
AdminAccountAsset::register($this);

?>

<div class="site-account-deletion">
    <div class="container">
        <div class="col-lg-5">
            <form id="deletion-form">
                <div class="input-group">
                    <input type="text" id="input-email" class="form-control" placeholder="Search user by email...">
                    <span class="input-group-btn">
                        <button id="btn-search" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
            <div id="results">
            <script id="deletion-template" type="text/x-handlebars-template">
                <div class="col-md-6 well-sm container">
                    <table class="table table-bordered table-hover table-sm">
                        <tbody>
                            <tr>
                                <td class="table-info">id</td>
                                <td class="table-warning">{{id}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">auth_key</td>
                                <td class="table-warning">{{auth_key}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">password_hash</td>
                                <td class="table-warning">{{password_hash}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">password_reset_token</td>
                                <td class="table-warning">{{password_reset_token}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">email</td>
                                <td class="table-warning">{{email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn-sm btn-primary" onclick="deleteUser('{{email}}')">Delete User</button>
                </div>
             </script>
                </div>
        </div>
    </div>
</div>
