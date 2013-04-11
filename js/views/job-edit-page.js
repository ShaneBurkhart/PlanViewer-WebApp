var app = app || {};

app.JobEditView = Backbone.View.extend({
    children : {},
	id : "job-files",
    template : _.template(app.Templates["job-edit"]),

	initialize: function() {
        this.children.fileListView = new app.FileListView({jobId : this.options.jobId});
        this.children.jobView = new app.JobView({jobId : this.options.jobId});
        this.render();
    },

    render : function(){
        this.$el.html(this.template());
        this.$el.prepend(this.children.jobView.el);
        this.$el.append(this.children.fileListView.el);
    }
});