var app = app || {};

app.FileItemView = Backbone.View.extend({
	tagName : "li",
	className : "file-container",
	template : _.template(app.Templates["file-item"]),

	events : {
	}, 

	getParent : function(e){
		var jobContainer = $(e.target);
		while(jobContainer.attr("class") != this.className)
			jobContainer = jobContainer.parent();
		return jobContainer;
	},

	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});