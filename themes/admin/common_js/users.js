function viewUser(id) {
    $.ajax({
        type: 'post',
        url: site_path + 'admin_ajax/viewUser',
        data: {
            'id': id
        },
        success: function(data) {
            if (data) {
                var response = JSON.parse(data);
                //alert(data);
                $("#viewData").empty();
                if(response[0].user_type=='1'){
                    var usrtype='Artist';
                }else if(response[0].user_type=='0'){
                    var usrtype='Fan';
                }
                $("#viewData").append("<tr><td>User Type</td><td>" + usrtype + "</td></tr>");
                
                $("#viewData").append("<tr><td>Frist Name</td><td>" + response[0].user_firstname + "</td></tr>");
                $("#viewData").append("<tr><td>Last Name</td><td>" + response[0].user_lastname + "</td></tr>");
                $("#viewData").append("<tr><td>Email</td><td>" + response[0].user_email + "</td></tr>");       
                $("#viewData").append("<tr><td>Location</td><td>" + response[0].country_name + " , " + response[0].state_name + " , " + response[0].city_name + " </td></tr>");
                $("#viewData").append("<tr><td>Username</td><td>" + response[0].user_username + "</td></tr>");
                $("#viewData").append("<tr><td>Created At </td><td>" + response[0].user_ts + "</td></tr>");
                if(response[0].vote_type=='m'){ 
                    $("#viewData").append("<tr><td>Subscribe plan</td><td> Monthly <br/> "+response[0].vote_title+" </td></tr>");
                    var max_give_vote  = response[0].vote_maximum;
                }else if(response[0].vote_type=='y'){
                    $("#viewData").append("<tr><td>Subscribe plan</td><td> Yearly  <br/> "+response[0].vote_title+"  </td></tr>");
                    var max_give_vote  = response[0].vote_maximum;
                }else {
                    $("#viewData").append("<tr><td>Subscribe plan</td><td> Free </td></tr>");
                    var max_give_vote  = '5';
                }
                $("#viewData").append("<tr><td>Maximum vote  </td><td>" + max_give_vote + "</td></tr>");
                // $("#viewData").append("<tr><td>Total vote given  </td><td>" + max_give_vote + "</td></tr>");
                
                $("#viewData").append("<tr><td>Subscription  </td><td>" + response[0].sub_status + "</td></tr>");
                
                if(response[0].txnid){
                    $("#viewData").append("<tr><td>Transaction Id  </td><td>" + response[0].txnid + "</td></tr>");
                }

                if(response[0].payment_amount){
                    $("#viewData").append("<tr><td>Subscriptio amount  </td><td>$ " + response[0].payment_amount + "</td></tr>");    
                }
                
                if(response[0].payment_mode){
                    $("#viewData").append("<tr><td>Payment Mode  </td><td>" + response[0].payment_mode + "</td></tr>");
                }
                if(response[0].createdtime){
                    $("#viewData").append("<tr><td>Subscription Date  </td><td>" + response[0].createdtime + "</td></tr>");
                }                


            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function(data) {
            
            $('#viewAdmin').modal('show');
        }
    });
}


function deleteUser(id)
{
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: site_path + 'admin/admin_ajax/delUser',
        data: {
            'id': id
        },
        success: function(data) {
            if (data) {
                $(this).parent.parent().hide();
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#myModal').modal('hide');
        }
    });
}


