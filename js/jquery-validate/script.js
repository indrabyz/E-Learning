// 
//	jQuery Validate example script
//
//	Prepared by David Cochran
//	
//	Free for your use -- No warranties, no guarantees!
//

$(document).ready(function(){

	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions
	
		$('#contact-form').validate({
	    rules: {
	      name: {
	        minlength: 2,
	        required: true
	      },nama_lengkap: {
	        minlength: 5,
	        required: true
	      },username: {
	        minlength: 2,
	        required: true
	      },password:{
			minlength: 5,
	        required: true,
		  },password2: {
	        minlength: 5,
	        required: true,
			equalTo: password
	      },judul: {
	        minlength: 2,
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      },
	      subject: {
	      	minlength: 2,
	        required: true
	      },
	      message: {
	        minlength: 2,
	        required: true
	      }
	    },
	    highlight: function(label) {
	    	$(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('OK!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	  });
	  
	  $('#contact-form1').validate({
	    rules: {
	      name: {
	        minlength: 2,
	        required: true
	      },nama_lengkap: {
	        minlength: 5,
	        required: true
	      },username: {
	        minlength: 2,
	        required: true
	      },judul: {
	        minlength: 2,
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      },
	      subject: {
	      	minlength: 2,
	        required: true
	      },
	      message: {
	        minlength: 2,
	        required: true
	      }
	    },
	    highlight: function(label) {
	    	$(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('OK!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	  });
	  
	  $('#login').validate({
	    rules: {
	      name: {
	        minlength: 2,
	        required: true
	      },nama_lengkap: {
	        minlength: 5,
	        required: true
	      },username: {
	        minlength: 2,
	        required: true
	      },password:{
			minlength: 5,
	        required: true,
		  },password2: {
	        minlength: 5,
	        required: true,
			equalTo: password
	      },judul: {
	        minlength: 2,
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      },
	      subject: {
	      	minlength: 2,
	        required: true
	      },
	      message: {
	        minlength: 2,
	        required: true
	      }
	    },
	    highlight: function(label) {
	    	$(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('OK!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	  });
	  
	  $('#username_pass').validate({
	    rules: {
	      username: {
	        minlength: 2,
	        required: true
	      },pass:{
			minlength: 5,
	        required: true,
		  },repass: {
	        minlength: 5,
	        required: true,
			equalTo: pass
	      }
	    },
	    highlight: function(label) {
	    	$(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('OK!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	  });
		
	  
}); // end document.ready