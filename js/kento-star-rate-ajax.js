jQuery(document).ready(function(e)
	{
		
	e(".ksr-star").mouseenter(function()
		{
		
			var t=e(this).attr("postid");
			var n=e("#ksr-mouseenter-color").text();
			e("#ksr-stars-"+t+" .ksr-star").css("background-color",n);
			var r=e(this).attr("rate");
			var i=1;
			
			while(i<=r){
				e("#ksr-stars-"+t+" .ksr-"+i).css("background-color",n);
				i++
				}
				j=6;
			while(j>r)
				{
				var s=e("#ksr-bg-color").text();
				e("#ksr-stars-"+t+" .ksr-"+j).css("background-color",s);
			j--
			}
		});
		
		

		
		
	e(".ksr-star").mouseleave(function()
		{
			var postid=e(this).attr("postid");
			var currentrate_color=e("#ksr-currentrate-color").text();
			var currentrate=parseInt(e(this).parent().parent().attr("currentrate"));
			
			for(i=1;i<=currentrate;i++)
				{
					e("#ksr-stars-"+postid+" .ksr-"+i).css("background-color",currentrate_color);

				}
		
		
		})	


		
		
		
		e(".ksr-star").click(function(){
			var t=e(this).attr("postid");
			var n=parseInt(e(this).attr("rate"));
			
			var currentrate=parseInt(e(this).parent().parent().attr("currentrate"));
			var vote_count=parseInt(e(this).parent().parent().attr("vote_count"));
			
			var new_rate = Math.ceil((n+currentrate)/(vote_count+1));

			
			e(this).parent().parent().attr("currentrate",new_rate);
			
			e.ajax({type:"POST",url:kento_star_rate_ajax.kento_star_rate_ajaxurl,
			data:{action:"kento_star_rate_ajax",post_id:t,star_rate:n},
			success:function(n){
				e(".ksr-rate-status-"+t).fadeIn();
				e(".ksr-rate-status-"+t).html(n)}})});
				
	

	
	
	})