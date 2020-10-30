new Vue({
	el: '#form-vue',
	data: {
		first_name : '',
		last_name : '',
		domain: 'lafilgroup.com',
		list: []
	},

	created: function(){
		this.fetchTaskList();
	},


	computed: {
		email_address : function() {
			return this.first_name + '.' + this.last_name + '@' + this.domain;
		},
		password_text : function() {
			return this.first_name + '.' + this.last_name;
		},
		fullname : function() {
			return this.first_name + ' ' + this.last_name;
		},

	},

	methods: {
		fetchTaskList: function(){
			this.$http.get('api/companies', function(companies) {
				this.$set('list',companies);
			}.bind(this));

		}
	}
});

Vue.filter('domain', function(value, domain){
	return value.filter(function(item){
		return item.domain == domain;
	});
});