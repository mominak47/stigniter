(()=>{var __webpack_exports__={};function isEmpty(e){return!e.trim().length}window.app=window.angular.module("framilyShareApp",[]),app.controller("globalCtrl",["$scope","$http","uiModal","$compile","userSettings",function(e,t,s,n,o){window.set_user=t=>{e.user=t},e.toggleSidebar=()=>o.toggleSidebar(),e.toggleTheme=()=>o.toggleTheme(),e.restore_profile=(e,s=null,n=null)=>{swalWithBootstrapButtons.fire({title:"Are you sure?",icon:"warning",showCancelButton:!0,confirmButtonClass:"me-2",confirmButtonText:"Yes, Restore it!",cancelButtonText:"No, cancel!",reverseButtons:!0}).then((o=>{o.value&&t.post(`../../../api/user/${e}/restore`).then((e=>{null!==s&null!==n&&(s[n].is_deleted=!1),Toast.fire({icon:"success",title:e.data.message})}),(e=>{Toast.fire({icon:"error",title:e.data.message})}))}))},e.delete_profile=(e,s=null,n=null)=>{swalWithBootstrapButtons.fire({title:"Are you sure?",text:"You will be able to restore this account later.",icon:"warning",showCancelButton:!0,confirmButtonClass:"me-2",confirmButtonText:"Yes, delete it!",cancelButtonText:"No, cancel!",reverseButtons:!0}).then((o=>{o.value&&t.post(`../../../api/user/${e}/delete`).then((e=>{null!==s&null!==n&&(s[n].is_deleted=!0),Toast.fire({icon:"success",title:e.data.message})}),(e=>{Toast.fire({icon:"error",title:e.data.message})}))}))},e.edit_profile=e=>{s.openModal({title:"Edit "+e,size:"xl",body_classes:"p-0",html:`\n                <div>\n                 <iframe src="https://framilysharegroup.com/users-management/profile/${e}?iframe=true" width="100%" style="height:80vh"></iframe>\n                 </div>\n            `,onOpen:(e,t,s)=>{window.close_modal=()=>$(e).modal("hide"),t.$ModalCtrl},onClose:()=>{}})},e.send_mail=e=>{Array.isArray(e)||(e=[e]),e=JSON.stringify(e),e=JSON.parse(e),s.openModal({title:"Send Email",position:"center",size:"md",html:'\n            <form id="form-send-email" ng-submit="$ctrl.sendEmail();">\n            <div class="mb-3">\n                <label class="form-label">Recipient(s) - ({{$ctrl.users.length}})</label>\n                <input type="search" ng-if="$ctrl.users.length > 1" class="form-control form-control-sm mb-2" placeholder="Search Receipents" ng-model="$ctrl.search">\n                <div style="max-height:100px;overflow-y:scroll;">\n                    <span class="badge me-2 rounded-pill mb-2 bg-light text-dark d-inline-flex align-items-center" ng-repeat="r in $ctrl.users | filter : $ctrl.search">\n                        <span style="line-height:2">{{r.user_login}}</span> \n                        <button class="btn btn-sm p-0 rounded-circle ms-1" ng-click="$ctrl.removeUser(r.ID);">\n                        <svg viewBox="0 0 24 24" width="16" height="16" style="stroke:var(--bs-danger)" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>\n                        </button>\n                    </span>\n                </div>\n            </div>\n            <div class="mb-3">\n                <label class="form-label">Subject</label>\n                <input type="text" class="form-control form-control-sm" ng-model="$ctrl.subject" placeholder="Subject" required/>\n            </div>\n            <div class="mb-3">\n                <label class="form-label">Content</label>\n                <textarea class="form-control form-control-sm" rows="5" ng-model="$ctrl.content" required></textarea>\n            </div>\n            </form>\n            ',buttons:[{text:"Cancel",class:"btn-secondary btn-sm",event:{click:(e,t)=>{$(t).modal("hide")}}},{text:"Send Email",class:"btn-primary btn-sm",attr:{type:"submit",form:"form-send-email"}}],onOpen:(t,s,n)=>{let o=s.$ModalCtrl;o.users=e,o.content="Hi [[user_display_name]],\n",o.removeUser=e=>{const t=o.users.findIndex((t=>t.ID==e));o.users.splice(t,1)},o.sendEmail=()=>{let e=[];o.users.forEach((t=>e.push(t.ID)));const s={user_ids:e,message:o.content,subject:o.subject};n.post("../../../api/email/send",s).then((e=>{Toast.fire({icon:"success",title:e.data.message}),$(t).modal("hide")}),(e=>{Toast.fire({icon:"error",title:"Something went wrong. Please try again later."}),$(t).modal("hide")}))},s.$watch("$ModalCtrl.users",(function(){0==o.users.length&&$(t).modal("hide")}),!0)},onClose:()=>{}})},e.activateView=function(s,o){e.$ModalCtrl={},o(e,t),n(s.contents())(e),e.$apply()},e.changePassword=e=>{s.openModal({title:"Change Password",size:"sm",position:"center",html:'\n                <div class="mb-3">\n                    <label class="form-label">Password</label>\n                    <input type="password" ng-model="$ctrl.password" placeholder="******" id="change_pass_field_1" class="form-control"/>\n                </div>\n\n                <div>\n                    <label class="form-label">Confirm Password</label>\n                    <input type="password" ng-model="$ctrl.password_confirm" placeholder="******" id="change_pass_field_2" class="form-control"/>\n                </div>\n            ',buttons:[{text:"Close",class:"btn-danger btn-sm",event:{click:(e,t)=>$(t).modal("hide")}},{text:"Update",class:"btn-primary btn-sm",attr:{id:"update_password_button",disabled:!0}}],onOpen:(t,s,n)=>{let o=document.querySelector("#change_pass_field_1"),a=document.querySelector("#change_pass_field_2"),r=document.querySelector("#update_password_button");o.focus();let l=s.$ModalCtrl;const i=()=>{isEmpty(o.value)||isEmpty(a.value)||o.value!==a.value?r.disabled=!0:r.disabled=!1};s.$watch("$ModalCtrl.password",i),s.$watch("$ModalCtrl.password_confirm",i),l.reset=(e,s,o)=>{n.post("../../../../api/user/update/change-password",{user_id:e,password:s}).then((e=>{alert("Password has been changed successfuly."),$(t).modal("hide")}),(e=>{alert("Something went wrong"),$(t).modal("hide")}))},r.addEventListener("click",(function(){l.reset(e,l.password,l.password_confirm)}))},onClose:()=>{}})}}]),app.controller("editProfile",["$scope","$http","$timeout",function($scope,$http,$timeout){$scope.success=!1,$scope.error=!1,$scope.hide_alerts=!0,$scope.reset_response=()=>{$scope.success=!1,$scope.error=!1},$scope.edit_mode=!1,$scope.closeFrame=()=>{null!=window.parent.close_modal&&window.parent.close_modal()};const mandatory_fields=["user_email"],mandatory_meta_fields=["telegram","user_detail_mobile"];$scope.loading_states=!1,$scope.updateStates=e=>{e&&($scope.loading_states=!0,$http.get(`../../../../api/states/${e}`).then((e=>{$scope.states=e.data,0==$scope.states.filter((e=>e.state_id=$scope.user.meta.user_detail_state)).length&&($scope.user.meta.user_detail_state=$scope.states[0]._state_id),$scope.loading_states=!1})))},$scope.takeBackup=()=>{window.bc=angular.toJson($scope.user)},$scope.loadBackup=()=>{$scope.user=JSON.parse(window.bc),window.bc=void 0},$scope.show_alert=()=>{$scope.hide_alerts=!1,$timeout((function(){$scope.hide_alerts=!0}),3e3)},$scope.updateSingle=(map,value)=>{let user={meta:{}};eval(`user.${map} = value`),$scope.save(user)},$scope.save=e=>{let t=angular.toJson($scope.user);t=JSON.parse(t),void 0!==t.meta.user_detail_dob&&(t.meta.user_detail_dob=dateToStr(new Date(t.meta.user_detail_dob))),void 0!==t.meta.remind_date&&(t.meta.remind_date=dateToStr(new Date(t.meta.remind_date))),mandatory_fields.forEach(((e,s)=>{null!=t[e]&&0==t[e].length&&console.log("Mandaotry",e)})),mandatory_meta_fields.forEach(((e,s)=>{null!=t.meta[e]&&0==t.meta[e].length&&console.log("Mandaotry Meta",e)})),$scope.reset_response(),$http.post(`../../../../api/user/update/${window.profile_user_id}`,t).then((e=>{$scope.frame?(window.set_user(t),console.log(t),$scope.closeFrame()):$scope.edit_mode=!1,$scope.success=e.data.message,$scope.show_alert()}),(e=>{$scope.frame||($scope.edit_mode=!0),$scope.error=resp.data.message,$scope.show_alert()}))},$timeout((function(){document.querySelector("#first_name").focus()}),!1)}]),app.controller("emailTemplate",["$scope","$http","$timeout","$interval",function(e,t,s,n){e.renderIframe=e=>{var t=document.getElementById("frame");(t=t.contentWindow||t.contentDocument.document||t.contentDocument).document.open(),t.document.write(e),t.document.close()},e.submit=()=>document.querySelector("#form").submit(),s((function(){e.renderIframe(e.template.post_content)}),!1)}]),app.controller("signUpForm",["$scope","$http","$timeout",function(e,t,s){e.steps=["sponsor_and_package","contact_information","security_information"],e.current_step_no=0,e.current_step=()=>e.steps[e.current_step_no],e.updateStates=s=>{s&&(e.loading_states=!0,t.get(`../../../../api/states/${s}`).then((t=>{e.states=t.data,0==e.states.filter((t=>t.state_id=e.user.meta.user_detail_state)).length&&(e.user.meta.user_detail_state=e.states[0]._state_id),e.loading_states=!1})))},e.user={sponsor_username:null,sponsor_fullname:null,position:"R",product:"gift_pack_500",first_name:null,gender:null,country:null,email:null,mobile:null,password:null,confirm_password:null},e.previous=()=>{e.current_step_no>0&&e.current_step_no--},e.next=()=>{e.validate()&&null!=e.steps[e.current_step_no+1]&&(e.current_step_no++,e.error=null)},e.validate=(t=!0)=>{switch(console.log(t),e.error=null,e.current_step()){case"sponsor_and_package":return e.user.sponsor_username&&0!=e.user.sponsor_username.length?e.user.position&&["L","R"].includes(e.user.position)?!(!e.user.product||0==e.user.product.length)||(t&&(e.error="Product is required"),!1):(t&&(e.error="Position is required"),!1):(t&&(e.error="Sponsor username is required"),!1);case"contact_information":return e.user.meta.user_detail_name&&0!=e.user.meta.user_detail_name.length?e.user.meta.user_detail_gender&&0!=e.user.meta.user_detail_gender.length?e.user.email&&0!=e.user.email.length?!(!e.user.meta.user_detail_mobile||0==e.user.meta.user_detail_mobile.length)||(t&&(e.error="Mobile is required"),!1):(t&&(e.error="Email is required"),!1):(t&&(e.error="Gender is required"),!1):(t&&(e.error="First name is required"),!1);case"security_information":return e.user.password==e.user.confirm_password||(t&&(e.error="Password didn't match"),!1);default:return!1}return!1},window.sponsorChanged=t=>{e.user.sponsor_username=t.user_login.replace("FSG",""),e.user.sponsor_fullname=t.display_name,e.$apply()},e.addAccount=s=>{"security_information"==e.current_step()&&t.post("../../../api/admin/add-account",s).then((e=>{window.location.href="../../../users-management/profile/"+e.data.username}))}}]),app.directive("selectField",["$http",function($http){return{link:function(scope,elem,attrs){const field=elem[0];scope.items=[];const fetch_data=(e,t)=>{$http.get(`${attrs.selectField}?query=${e}`).then((e=>t(e)),(e=>console.log(`Error: ${e}`)))};window.handleSelect=(fn,index,renderAt)=>{const item=scope.items[index];eval(`window.${fn}(item)`),document.querySelector(renderAt).innerHTML=null};const makeUl=e=>{let t='<div class="list-group">';return e.forEach(((e,s)=>{t+=`<a href="#" class="list-group-item list-group-item-action" onClick="window.handleSelect('${attrs.onSelect}', ${s}, '${attrs.renderAt}')">${e.display_name} (${e.user_login})</a>`})),t+="</div>",t},handleChange=e=>{e.target.value.length>0&&fetch_data(e.target.value,(e=>{scope.items=e.data,document.querySelector(attrs.renderAt).innerHTML=makeUl(e.data)}))};field.addEventListener("keyup",handleChange)}}}]).component("adminNotes",{bindings:{user:"@"},template:'\n    <div class="card rounded">\n        <div class="card-body">\n            <h6 class="card-title">Admin Notes</h6>\n            <form ng-submit="$ctrl.addNote($ctrl.message);">\n            <div class="d-flex mb-3">\n                    <input class="form-control me-2 flex-fill" ng-model="$ctrl.message" placeholder="Type something">\n                    <a class="btn btn-primary btn-sm" type="button" ng-disabled="!$ctrl.message" ng-click="$ctrl.addNote($ctrl.message);">Save</a>\n                    </div>\n                    </form>\n            <div style="max-height:60vh;overflow-y:scroll;" class="px-2">\n                <div ng-repeat="n in $ctrl.notes" style="background-color:#f0f7fe;" class="d-flex flex-column justify-content-between mb-2 p-3 border rounded">\n                \n                <small class="tiny-muted">{{n.date}}</small>        \n                <p class="mb-0">{{n.message}}</p>\n                        <div class="mt-2">\n                            <a href="#" ng-click="$ctrl.delete(n.ID)">Delete</a>\n                        </div>\n                </div>\n            </div>\n\n            \n        </div>\n    </div>\n    ',controller:["$scope","$http",function(e,t){let s=this;s.$onInit=()=>{s.getNotes=()=>{t.get(`../../../../../../api/notes/${s.user}`).then((e=>{s.notes=e.data}))},s.addNote=e=>{t.post(`../../../../../../api/notes/${s.user}`,{message:e}).then((e=>{s.notes=[e.data,...s.notes],s.message=null}))},s.delete=e=>{t.post(`../../../../../../api/notes/delete/${e}`).then((t=>{s.notes=s.notes.filter((t=>t.ID!=e))}))},s.getNotes()}}]}).service("uiModal",[function(){this.openModal=e=>{void 0===e.dependencies&&(e.dependencies=[]);const t=`modal_${(new Date).getTime()}`;let s=`\n                <div class="modal-dialog ${e.size?"modal-"+e.size:""} ${e.position?"modal-dialog-"+e.position+"ed":""}"\n                \n                style='${null!=e.style?e.style:""}';\n\n                role="document">\n                <div class="modal-content">\n                    <div class="modal-header">\n                    <h5 class="modal-title">${void 0!==e.title?e.title:""}</h5>\n                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>\n                    </div>\n                    <div class="modal-body ${e.body_classes?e.body_classes:""}" ${e.body_style?'style="'+e.body_style+'"':""}>\n                        <div class="modal-loading">\n                            <div class="d-flex justify-content-center">\n                                <div class="spinner-border text-primary" role="status"></div>\n                            </div>\n                        </div>\n                        <div class="modal-controller" style="display:none;">\n                             ${e.html?e.html:""}\n                        </div>\n                    </div>\n                    <div class="modal-footer text-end" style="display:none;">\n                      \n                    </div>\n                </div>\n                </div>\n            `;s=s.split("$ctrl").join("$ModalCtrl");const n=document.createElement("DIV");n.classList.add("modal"),n.classList.add("fade"),n.setAttribute("role","dialog"),n.setAttribute("aria-hidden",!0),n.setAttribute("id",t),n.innerHTML=s,void 0!==e.buttons&&e.buttons.length>0&&e.buttons.forEach((e=>{const t=document.createElement("BUTTON");if(t.innerText=e.text,void 0!==e.event)for(var s in e.event)t.addEventListener(s,(t=>{e.event[s](t,n)}));if(void 0!==e.attr)for(var o in e.attr)t.setAttribute(o,e.attr[o]);t.classList.add("btn"),e.class&&e.class.split(" ").forEach((e=>{t.classList.add(e)})),n&&t&&n.querySelector(".modal-footer")&&n.querySelector(".modal-footer").appendChild(t)})),document.body.appendChild(n),$(n).modal("show");const o=()=>{document.onkeydown=function(e){("key"in(e=e||window.event)?"Escape"===e.key||"Esc"===e.key:27===e.keyCode)&&$(n).modal("hide")};var t=angular.element(document.querySelector("body")),s=angular.element(document.querySelector(".modal-controller"));t.scope().activateView(s,(function(t,s,o){document.querySelector(".modal-controller").style.display="block",document.querySelector(".modal-loading").style.display="none",document.querySelector(".modal-footer").style.display="block",e.onOpen(n,t,s,o)}))};$(n).on("show.bs.modal",(t=>void 0!==e.beforeOpen&&o())),$(n).on("shown.bs.modal\t",(t=>void 0!==e.onOpen&&o())),$(n).on("hidden.bs.modal",(t=>{angular.element(document.querySelector("body")).scope().$ModalCtrl=null,n.remove(),void 0!==e.onClose&&e.onClose(n)}))}}]),app.directive("ngInitDate",(function(){return{link:function(scope,el,attrs){const model=attrs.ngModel,date=attrs.ngInitDate;eval(`scope.${model} = new Date("${date}");`)}}})),app.directive("ngGetTextarea",(function(){return{link:function(scope,el,attrs){const model=attrs.ngModel,value=el[0].value;eval(`scope.${model} = value;`)}}})),app.directive("myProfilePicture",["httpPostFactory",function(e){return{restrict:"A",link:function(t,s,n){s.bind("change",(function(){var n=new FormData;n.append("file",s[0].files[0]);var o=s[0].files[0];t.fileLog={lastModified:o.lastModified,lastModifiedDate:o.lastModifiedDate,name:o.name,size:o.size,type:o.type},t.$apply(),e("../../../api/user/update_photo",n,(function(e){document.querySelector(".user-photo").style.backgroundImage=`url(${e.data.image})`}))}))}}}]),app.factory("httpPostFactory",["$http",function(e){return function(t,s,n){e({url:t,method:"POST",data:s,headers:{"Content-Type":void 0}}).then((function(e){n(e)}))}}]),app.directive("fileInput",["$parse",function(e){return{restrict:"A",link:function(t,s,n){console.log("loaded"),s.bind("change",(function(){e(n.fileInput).assign(t,s[0].files),t.$apply()}))}}}]),app.controller("submitVerification",["$scope","$http",function(e,t){e.get_phone_code=e=>{const t=get_countries().filter((t=>t.country_id==e));if(t.length>0)return"+"+t[0].phone_code},e.loading_states=!1,e.updateStates=s=>{s&&(e.loading_states=!0,t.get(`../../../../api/states/${s}`).then((t=>{e.states=t.data,0==e.states.filter((t=>t.state_id=e.user.meta.user_detail_state)).length&&(e.user.meta.user_detail_state=e.states[0]._state_id),e.loading_states=!1})))},e.submit=()=>{e.submit_start=!0;var s=new FormData;let n=angular.toJson(e.user);n=JSON.parse(n),void 0!==n.meta.user_detail_dob&&(n.meta.user_detail_dob=dateToStr(new Date(n.meta.user_detail_dob))),void 0!==n.meta.remind_date&&(n.meta.remind_date=dateToStr(new Date(n.meta.remind_date))),s.append("user_data",JSON.stringify(n)),s.append("id_file",e.national_id[0]),s.append("address_proof_file",e.address_proof_file[0]),t.post("https://framilysharegroup.com/verification/submit",s,{transformRequest:angular.identity,headers:{"Content-Type":void 0,"Process-Data":!1},uploadEventHandlers:{progress:function(t){t.lengthComputable&&(e.showProgress=!0,e.progressBar=t.loaded/t.total*100,e.progressCounter=e.progressBar.toFixed(2)+" %")}}}).then((function(t){Swal.mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,timerProgressBar:!0}).fire({icon:"success",title:"Form Submitted"}),e.submit_start=!1,window.location.reload()}),(e=>{console.log(e)}))}}]),app.service("userSettings",["$http",function(e){this.toggleTheme=()=>{let e=null;e="demo1"==document.querySelector("#theme").getAttribute("data-current")?"demo2":"demo1",this.update_setting("theme",e,(()=>{window.location.reload()}))},this.toggleSidebar=()=>{document.querySelector("body").classList.contains("sidebar-folded")?this.update_setting("sidebar","closed"):this.update_setting("sidebar","opened")},this.update_setting=(t,s,n=!1,o=!1)=>{e.post("../../../api/user/update_theme_settings",{name:t,value:s}).then((e=>{n&&n(e)}),(e=>{o&&o(e)}))}}])})();
