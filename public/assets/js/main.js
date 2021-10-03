$(document).ready(function(){
	
	// add category form
	$('#add-category-form').parsley().on('form:submit', function (formInstance) {
			var form=$('#add-category-form')
		    var url=form.attr('action');
            var formData=form.serialize(); 

            $.ajax({
                    url: url,
                    type: "post",                            
                    data: formData,                            
                    beforeSend:function(){
                      form.find('input').blur()
                      // show processing spinner
                      form.LoadingOverlay("show")
                    },
                    success: function(data) {
                        
                        if(data['success'] == false){
                        	swal({
		                        title: "Caution",
		                        text: data['validation_error'],
		                        type: "error",
		                      	html:true,
		                  	}) 
                        }else{
                        	form.trigger("reset");
	                    	$('#add-category-modal').modal('hide')
	                    	swal({
			                        title: "Success",
			                        text: data['message'],
			                        type: "success",
			                      	html:true,
			                })


			                $('.categories-container').html(data['categories_html']) 

                        } 
                                                               		
                  
                        // hide processing spinner
                        form.LoadingOverlay("hide",true)                       
                        
                    },
                    error: function(){
                    	swal({
	                        title: "Caution",
	                        text: "Failed sending data to server, please try again.",
	                        type: "error",
	                      	html:true,
		                }) 
                      
                      // hide processing spinner
                        form.LoadingOverlay("hide",true)
                    }                   
            })   

	    // prevent form submit
		return false;
	});

	// add sub category form
	$('#add-sub-category-form').parsley().on('form:submit', function (formInstance) {
			var form=$('#add-sub-category-form')
		    var url=form.attr('action');
            var formData=form.serialize(); 

            $.ajax({
                    url: url,
                    type: "post",                            
                    data: formData,                            
                    beforeSend:function(){
                      form.find('input').blur()
                      // show processing spinner
                      form.LoadingOverlay("show")
                    },
                    success: function(data) {
                        
                        if(data['success'] == false){
                        	swal({
		                        title: "Caution",
		                        text: data['validation_error'],
		                        type: "error",
		                      	html:true,
		                  	}) 
                        }else{
                        	form.trigger("reset");
	                    	$('#add-sub-category-modal').modal('hide')
	                    	swal({
			                        title: "Success",
			                        text: data['message'],
			                        type: "success",
			                      	html:true,
			                })

			                $('.categories-container').html(data['categories_html']) 
                        } 
                                                       		
                        // hide processing spinner
                        form.LoadingOverlay("hide",true)                       
                        
                    },
                    error: function(){
                    	swal({
	                        title: "Caution",
	                        text: "Failed sending data to server, please try again.",
	                        type: "error",
	                      	html:true,
		                }) 
                      
                      // hide processing spinner
                        form.LoadingOverlay("hide",true)
                    }                   
            })   

	    // prevent form submit
		return false;
	})

	$('#add-category-modal').on('hidden.bs.modal', function (e) {
	  $('#add-category-form').trigger("reset")
	  $('#add-category-form').parsley().reset()
	})

	$('#add-sub-category-modal').on('hidden.bs.modal', function (e) {
	  $('#add-sub-category-form').trigger("reset")
	  $('#add-sub-category-form').parsley().reset()
	})

	$(document).on('mouseover','.category',function(){
		$('.delete-category-btn').addClass('d-none')
		$(this).find('h5').find('.delete-category-btn').removeClass('d-none')

		$('.add-category-btn').addClass('d-none')
		$(this).find('h5').find('.add-category-btn').removeClass('d-none')

		var category_title = $(this).find('h5').find('span').text()
		var category_id = $(this).find('h5').find('.add-category-btn').attr('data-category-id')
        $('#category-title-value').val(category_title)
        $('#add-sub-category-form input[name=category_id]').val(category_id)
	})

	$(document).on('mouseout','.category',function(){
		$('.add-category-btn').addClass('d-none')
		$('.delete-category-btn').addClass('d-none')
	})

	$(document).on('mouseout','.sub-category',function(){
		$('.delete-sub-category-btn').addClass('d-none')
	})
	$(document).on('mouseover','.sub-category',function(){

		$('.delete-sub-category-btn').addClass('d-none')
		$(this).find('button').removeClass('d-none')

	})

	$(document).on('click','.delete-sub-category-btn',function(){
		var id = $(this).attr('data-id')
		var url = $(this).attr('data-url')
		var csrf_token =$('meta[name="csrf-token"]').attr('content')

        swal({
		  title:"Are you sure?",
		  text: "Once deleted this item can not be recovered.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Yes, delete!",
		  cancelButtonText: "No, cancel please!",
		},
		function(isConfirm){
		  if (isConfirm) {
		            // delete sub category 
												
		            $.ajax({
		                    url: url,
		                    type: "post",                            
		                    data: { id : id, _token :csrf_token},                            
		                    beforeSend:function(){
		                      // show processing spinner
		                      $('body').LoadingOverlay("show")
		                    },
		                    success: function(data) {
		                        
		                        if(data['success'] == false){
		                        	swal({
				                        title: "Caution",
				                        text: data['validation_error'],
				                        type: "error",
				                      	html:true,
				                  	}) 
		                        }else{
			                    	swal({
				                        title: "Success",
				                        text: data['message'],
				                        type: "success",
				                      	html:true,
					                })

					                $('.categories-container').html(data['categories_html']) 
		                        } 
		                                                       		
		                        // hide processing spinner
		                        $('body').LoadingOverlay("hide",true)                       
		                        
		                    },
		                    error: function(){
		                    	swal({
			                        title: "Caution",
			                        text: "Failed sending data to server, please try again.",
			                        type: "error",
			                      	html:true,
				                }) 
		                      
		                      // hide processing spinner
		                        $('body').LoadingOverlay("hide",true)
		                    }                   
		            })   
		  } 
		})
	})

	$(document).on('click','.delete-category-btn',function(){
		var id = $(this).attr('data-id')
		var url = $(this).attr('data-url')
		var csrf_token =$('meta[name="csrf-token"]').attr('content')

        swal({
		  title:"Are you sure?",
		  text: "Once deleted this item can not be recovered.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Yes, delete!",
		  cancelButtonText: "No, cancel please!",
		},
		function(isConfirm){
		  if (isConfirm) {
		            // delete category 
												
		            $.ajax({
		                    url: url,
		                    type: "post",                            
		                    data: { id : id, _token :csrf_token},                            
		                    beforeSend:function(){
		                      // show processing spinner
		                      $('body').LoadingOverlay("show")
		                    },
		                    success: function(data) {
		                        
		                        if(data['success'] == false){
		                        	swal({
				                        title: "Caution",
				                        text: data['validation_error'],
				                        type: "error",
				                      	html:true,
				                  	}) 
		                        }else{
			                    	swal({
				                        title: "Success",
				                        text: data['message'],
				                        type: "success",
				                      	html:true,
					                })

					                $('.categories-container').html(data['categories_html']) 
		                        } 
		                                                       		
		                        // hide processing spinner
		                        $('body').LoadingOverlay("hide",true)                       
		                        
		                    },
		                    error: function(){
		                    	swal({
			                        title: "Caution",
			                        text: "Failed sending data to server, please try again.",
			                        type: "error",
			                      	html:true,
				                }) 
		                      
		                      // hide processing spinner
		                        $('body').LoadingOverlay("hide",true)
		                    }                   
		            })   
		  } 
		})
	})
})