<script src="/js/jquery.min.js" charset="utf-8"></script>
<script src="/js/semantic.min.js" charset="utf-8"></script>
<script type="text/javascript">
  $('.onloading').each(function() {
      $(this).parents('form:first').submit(function(e){
          $(this).find('button').prop('disabled', false);
          $(this).find('button').addClass('loading');
      });
  });
</script>

@stack('scripts')
