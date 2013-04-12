var app = app || {};

app.JobView = Backbone.View.extend({
	tagName : "div",
	className : "job",
	template : _.template(app.Templates["job"]),

	initialize : function(){
		if(!app.collections.jobListCollection || !(this.model = app.collections.jobListCollection.get(this.options.jobId))){
			this.model = new app.JobItemModel(0, {url : "api/job/" + this.options.jobId});
			this.model.fetch();
		}else
			this.render();
        this.listenTo(this.model, "change", this.render);
    },

	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});