		$.ajaxSetup({
			cache: false
			});

		function getMenu(){
			$("body").css("cursor", "progress");
			$("#content").load('menu.php', function() {
				$("body").css("cursor","auto");
			});
		}

		function getOrder(){
			$("body").css("cursor", "progress");
			$("#content").load("order.php", function() {
				$("body").css("cursor","auto");
			});
		}

		function getHistory(){
			$("body").css("cursor", "progress");
			$("#content").load('history.php', function() {
				$("body").css("cursor","auto");
			});
		}

		function getAbout(){
			$("body").css("cursor", "progress");
                        $("#content").load('about.php', function() {
				$("body").css("cursor","auto");
			});
		}


        	function toggleToppingExtra(id){
			var element = "Topping" + id + "Extra";
			var element2 = "topping" + id + "span";
			if (document.getElementById("Topping" + id).checked == false){
				document.getElementById(element).checked = false;
				document.getElementById(element).setAttribute("class","noshow toppingtdExtra");
				document.getElementById(element2).setAttribute("class","noshow toppingtdExtra");

			}else{
				document.getElementById(element2).setAttribute("class","show toppingtdExtra");
                		document.getElementById(element).setAttribute("class","show toppingtdExtra");
			}
        	}

		function addPizza(){
		    	$.ajax({ // create an AJAX call...
        		data: $('#pizzaForm').serialize(), // get the form data
        		type: $('#pizzaForm').attr('method'), // GET or POST
        		url: $('#pizzaForm').attr('action') + "?action=addPizza", // the file to call
        		success: function(response) { // on success..
        			document.getElementById('content').innerHTML = response;
				}
		        });
   		}	

                function orderContinue(){
                        $.ajax({ // create an AJAX call...
                        data: $('#pizzaForm').serialize(), // get the form data
                        type: $('#pizzaForm').attr('method'), // GET or POST
                        url: $('#pizzaForm').attr('action') + "?action=continue", // the file to call
                        success: function(response) { // on success..
                                document.getElementById('content').innerHTML = response;
                                }
                        });
                }



                function addExtra(){
                        $.ajax({ // create an AJAX call...
                        data: $('#pizzaExtraForm').serialize(), // get the form data
                        type: $('#pizzaExtraForm').attr('method'), // GET or POST
                        url: $('#pizzaExtraForm').attr('action') + "?action=addExtra", // the file to call
                        success: function(response) { // on success..
                                document.getElementById('content').innerHTML = response;
                                }
                        });
                }


                function orderFinish(){
                        $.ajax({ // create an AJAX call...
                        data: $('#pizzaExtraForm').serialize(), // get the form data
                        type: $('#pizzaExtraForm').attr('method'), // GET or POST
                        url: $('#pizzaExtraForm').attr('action') + "?action=finish", // the file to call
                        success: function(response) { // on success..
                                document.getElementById('content').innerHTML = response;
                                }
                        });
                }


