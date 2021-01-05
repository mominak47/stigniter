<div layout="row" layout-align="center center" style="height:100vh" layout-padding>

    <div class="container" flex="100" flex-gt-sm="35" flex-gt-md="20" >

        <md-card style="margin:0;border-radius:8px;">
            <md-content layout-padding style="border-radius: 8px;">
                
            <div ng-if="!loading">
                <div layout="column" layout-align="center center">
                    <figure>
                        <img src="<?= base_url("assets/site-logo.png");?>" alt="">
                    </figure>
                    <small>{{strings["Login with your email address."]}}</small>
                </div>
                <form name="userForm">
                    <md-input-container class="md-block">
                        <label>{{strings["Email/Username"]}}</label>
                        <input ng-model="user.email" id="input_email">
                    </md-input-container>
                    
                    
                    <md-input-container class="md-block">
                        <label>{{strings["Password"]}}</label>
                        <input ng-model="user.password" type="password">
                    </md-input-container>
                    
                    <div>
                        <md-button type="submit" style="margin:0;" class="md-primary">Continue</md-button>
                    </div>
                    
                </form>
            </div>

            <div layout="column" layout-align="center center" ng-if="loading" style="height:321.05px;">
                <md-progress-circular class="md-accent" md-diameter="40"></md-progress-circular>
            </div>

            </md-content>
        </md-card>

        <div class="footer">
            <small>Welcome to Vato App</small><br/>
            <small>Forgot Password? | About Us </small>
        </div>

    </div>

</div>