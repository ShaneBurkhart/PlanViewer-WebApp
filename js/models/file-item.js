var app = app || {};

app.FileModel = Backbone.Model.extend({
	defaults : {
		id : null,
		filename : "No filename",
		date : "No Date",
		job_id : null,
		page_num : null,
		filename : "No Filename",
		version : null
	}
});