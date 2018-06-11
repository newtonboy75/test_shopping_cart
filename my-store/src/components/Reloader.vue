var vueRouteReloader = Vue.extend(
{
	template: '<div/>',
	mounted: function()
	{
		setTimeout(function() { router.back(); }, 100);
	}
});
