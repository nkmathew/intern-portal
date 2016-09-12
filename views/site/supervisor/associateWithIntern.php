<?php
/**
 * Project: Intern Portal.
 * User: nkmathew
 * Date: 03/09/2016
 * Time: 03:38
 */

use app\assets\SupervisorReviewsAsset;
SupervisorReviewsAsset::register($this);

?>

<div class="site-associate-with-intern">
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
            <script id="association-template" type="text/x-handlebars-template">
                <div class="col-md-6 well-sm container">
                    <table class="table table-bordered table-hover table-sm">
                        <tbody>
                            <tr>
                                <td class="table-info">id</td>
                                <td class="table-warning">{{id}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">Auth Key</td>
                                <td class="table-warning">{{auth_key}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">Password Hash</td>
                                <td class="table-warning">{{password_hash}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">Account Created</td>
                                <td class="table-warning">{{created_at}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">email</td>
                                <td class="table-warning">{{email}}</td>
                            </tr>
                            <tr>
                                <td class="table-info">Role</td>
                                <td class="table-warning"><strong>{{role}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="">
                        <button class="btn btn-primary" onclick="sendAssociationLink('{{email}}')">
                            Send association link
                        </button>
                    </div>
                </div>
             </script>
                </div>
        </div>
    </div>
</div>
