var app = app || {};

app.JobView = Backbone.View.extend({
	tagName : "div",
	className : "job",
	template : _.template(app.Templates["job"]),

	initialize : function(){
		this.model = new app.JobItemModel(0, {url : "api/job/" + this.options.jobId});
        this.model.fetch();
        this.listenTo(this.model, "change", this.render);
    },

	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});