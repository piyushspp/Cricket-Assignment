$(document).ready(function(){ 
    
    $("#add-edit-team").click(function(){
        
        let url = $("#domain").val() + "api/team-add",
            method = "POST",
            form = $('#myform')[0],
            data = new FormData(form);
            
        if($('input[type="file"]')[0].files.length !== 0){   
            let Extension = $('input[type="file"]')[0].files[0].name.substring(
                    $('input[type="file"]')[0].files[0].name.lastIndexOf('.') + 1).toLowerCase(),
                validExtensions = ['jpg','png','jpeg','gif','svg'];
            if ($.inArray(Extension, validExtensions) == -1) {
                $(".valid-image").removeClass('d-none');
                return false;
            }    
            data.append('logoUri',$('input[type="file"]')[0].files[0]);
        }    
      
        if($("#name").val() == ""){
            $(".t-name").removeClass('d-none');
        }
        if($("#state").val() == ""){
            $(".s-name").removeClass('d-none');
        }
        
        if($("#teamId").val() !== ""){
            data.append('teamId',$("#teamId").val());
            url = $("#domain").val() + "api/team-edit";
        }else{
            if($('input[type="file"]')[0].files.length === 0){
                $(".comlogo-name").removeClass('d-none'); 
                return false;
             }
        }
        if(($("#name").val() !== "") && ($("#state").val() !== "")){
            $.ajax({
                url: url,
                type: method,
                contentType: false,
                processData: false,
                cache: false,
                data: data,
                headers: {
                },
                beforeSend: function (xhr) {
                    //validate.loader('show');
                },
                success: function (data, textStatus, xhr) {    
                    window.location.href = $("#domain").val() + 'home';
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Something went wrong.");
                }
            });
       }
    }); 
    
    $("#logoUri, #imageUri").change(function() {
        $(".comlogo-name, .playerImage-name, .valid-image").addClass('d-none');
    });
    
    $('#name').keypress(function (event) {
        $(".t-name").addClass('d-none');
    });
    
    $('#state').keypress(function (event) {
        $(".s-name").addClass('d-none');
    });
    
    $(".deleteTeam").click(function(){
        let url = $(".deleteTeam").attr('domain') + "api/team/"+$(".deleteTeam").attr('id');
        if (confirm('Are you sure you want to delete this team?')) {
            $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({"teamId": $(".deleteTeam").attr('id')}),
                    headers: {
                    },
                    beforeSend: function (xhr) {
                        //validate.loader('show');
                    },
                    success: function (data, textStatus, xhr) {    
                        window.location.href = $(".deleteTeam").attr('domain') + 'home';
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Something went wrong.");
                    }
            });
        }    
    });
    
    $("#add-edit-player").click(function(){
        
        let validate = validateForm(),
            url = $("#domain").val() + "api/player-add",
            method = "POST",
            form = $('#playerForm')[0],
            data = new FormData(form);
        
        if($('input[type="file"]')[0].files.length !== 0){    
            let Extension = $('input[type="file"]')[0].files[0].name.substring(
                    $('input[type="file"]')[0].files[0].name.lastIndexOf('.') + 1).toLowerCase(),
                validExtensions = ['jpg','png','jpeg','gif','svg'];
            if ($.inArray(Extension, validExtensions) == -1) {
                $(".valid-image").removeClass('d-none');
                return false;
            }    
            data.append('imageUri',$('input[type="file"]')[0].files[0]);
        } 
        
        if($("#playerId").val() !== ""){
            url = $("#domain").val() + "api/player-edit";
        }else{
            if($('input[type="file"]')[0].files.length === 0){
                $(".playerImage-name").removeClass('d-none'); 
                return false;
             }
        }
        if(validate == true){

            $.ajax({
                url: url,
                type: method,
                contentType: false,
                processData: false,
                cache: false,
                data: data,
                headers: {
                },
                beforeSend: function (xhr) {
                    //validate.loader('show');
                },
                success: function (data, textStatus, xhr) {    
                    window.location.href = $("#domain").val() + 'player-list';
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Something went wrong.");
                }
            });
        }
    });
    
    function validateForm(){
        if($("#firstName").val() == ""){
            $(".f-name").removeClass('d-none');  
            return false;
        }
        if($("#lastName").val() == ""){
            $(".l-name").removeClass('d-none');  
            return false;
        }
        if($("#playerJersyNumber").val() == ""){
            $(".jersy-number").removeClass('d-none');  
            return false;
        }
        if($("#country").val() == ""){
            $(".country").removeClass('d-none'); 
            return false;
        }
        if($("#matches").val() == ""){
            $(".matches").removeClass('d-none');  
            return false;
        }
        if($("#run").val() == ""){
            $(".run").removeClass('d-none');  
            return false;
        }
        if($("#highestScore").val() == ""){
            $(".h-score").removeClass('d-none');  
            return false;
        }
        if($("#fifties").val() == ""){
            $(".fifties").removeClass('d-none');  
            return false;
        }
        if($("#hundreds").val() == ""){
            $(".hundreds").removeClass('d-none');  
            return false;
        }
        return true;
    }
    
    $('#firstName').keypress(function (e) {
        $(".f-name").addClass('d-none');
    });
    
    $('#lastName').keypress(function (e) {
        $(".l-name").addClass('d-none');
    });
    
    $('#playerJersyNumber').keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
        $(".jersy-number").addClass('d-none');
    });
    
    $('#country').keypress(function (e) {
        $(".country").addClass('d-none');
    });
    $('#matches').keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
        $(".matches").addClass('d-none');
    });
    $('#run').keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
        $(".run").addClass('d-none');
    });
    $('#highestScore').keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
        $(".h-score").addClass('d-none');
    });
    $('#fifties').keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
        $(".fifties").addClass('d-none');
    });
    $('#hundreds').keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
        $(".hundreds").addClass('d-none');
    });
    
    
    $("#addPlayerToTeam").click(function(){
        
        let url = $("#domain").val() + "api/assign-playerto-team",
            method = "POST";
        
        if(($("#teamId").val() !== "") && ($("#playerId").val() !== "")){
            let obj = { teamId: $("#teamId").val(), playerId: $("#playerId").val()},
                data = JSON.stringify(obj);
            
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                contentType: 'application/json',
                data: data,
                headers: {
                },
                beforeSend: function (xhr) {
                    //validate.loader('show');
                },
                success: function (data, textStatus, xhr) {    
                    window.location.href = $("#domain").val() + 'team-detail/'+$("#teamId").val();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Something went wrong.");
                }
            });
       }
    });
    
    $(".removePlayer").click(function(){
        
        let url = $(".removePlayer").attr('domain') + "api/remove-player-from-team";
        if (confirm('Are you sure you want to remove this player from team?')) {
            $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({"teamId": $(".removePlayer").attr('player'),"playerId":this.id}),
                    headers: {
                    },
                    beforeSend: function (xhr) {
                        //validate.loader('show');
                    },
                    success: function (data, textStatus, xhr) {    
                        window.location.reload(true);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert("Something went wrong.");
                    }
            });
        }    
    });
    
    $("#executeMatch").click(function(){
        
        if($("#teamOne").val() === $("#teamTwo").val()){
            $(".teamTwoId").removeClass('d-none');
            return false;
        }
        let url = $("#domain").val() + "api/play-match",
            method = "POST";
        
        if(($("#teamOne").val() !== "") && ($("#teamTwo").val() !== "") && ($("#winner").val() !== "")){
            let obj = { teamOne: $("#teamOne").val(), teamTwo: $("#teamTwo").val(), winner: $("#winner").val()},
                data = JSON.stringify(obj);
            
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                contentType: 'application/json',
                data: data,
                headers: {
                },
                beforeSend: function (xhr) {
                    //validate.loader('show');
                },
                success: function (data, textStatus, xhr) {    
                    window.location.href = $("#domain").val() + 'home/';
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Something went wrong.");
                }
            });
       }
    });
    
    $( ".target" ).change(function() {
        $(".teamTwoId").addClass('d-none');
    });
});