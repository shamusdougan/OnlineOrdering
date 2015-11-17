
	
$(document).on('click', '.button_print', function() 
	{	
		var windowSizeArray = [ 'width=200,height=200',
                            'width=300,height=400,scrollbars=yes' ];

		var url = $(this).attr('print_url');
		
		
    	var windowName = 'Print';
    	var windowSize = windowSizeArray[$(this).attr('rel')];

    	window.open(url, windowName, windowSize);
	});
