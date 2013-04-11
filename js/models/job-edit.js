var app = app || {};

app.JobEditModel = Backbone.Model.extend({
	urlRoot : "/api/job",
	defaults : {
		id : null,
		name : "No Name"
	}
});