var app = app || {};

app.Templates = (function(){
	var tempNames = ["job-page", "job-item", "user-item", "user-page", "job-edit", "page-item", "job", "job-side-bar", "job-edit-side-bar"],
	baseUrl = "js/templates/",
	temps = {};
	$.each(tempNames, function(index, name){
		$.ajax({
			url : baseUrl + name + ".html",
			async : false,
			success : function(data){
				temps[name] = data;
			}
		});	
	});
	return temps;
})();