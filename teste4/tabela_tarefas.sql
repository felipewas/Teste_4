CREATE TABLE IF NOT EXISTS `tarefas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(80) NOT NULL,
  `descricao` text NOT NULL,
  `prioridade` set('Alta','Media','Normal') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `tarefas` (`id`, `titulo`, `descricao`, `prioridade`) VALUES
(1, 'Tarefa 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean finibus pharetra mauris a accumsan. scelerisque, cursus augue sit amet, gravida diam. Nam accumsan sem a tristique lobortis. Nulla facilisi. Maecenas eget efficitur felis.', 'Alta'),
(2, 'Tarefa 2', 'Nunc eget metus posuere est tristique laoreet lacinia a augue. Curabitur massa leo, consequat vel egestas ac, tristique vitae nibh. Duis eleifend odio leo, ac accumsan ipsum euismod sit amet.', 'Media'),
(3, 'Tarefa 3', 'Sed sit amet eros lacinia, tincidunt elit interdum, venenatis velit. Quisque sit amet commodo ipsum, vitae ullamcorper ante. Cras tristique nunc vitae congue imperdiet. Ut eros velit, tristique vitae nunc sed, maximus venenatis metus. Sed et consectetur lectus. Donec pharetra, felis vitae vulputate sodales, metus neque aliquet lectus, eget pretium dolor lorem ac nunc.', 'Normal'),
(4, 'Tarefa 4', 'Proin mattis turpis sed dolor lacinia tempus sed non purus. placerat metus. Vivamus nec tempor sapien, eget finibus turpis.', 'Alta'),
(5, 'Tarefa 5', 'Sed sit amet eros lacinia, tincidunt elit interdum, venenatis velit.', 'Normal');
