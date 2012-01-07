<?php

namespace Bob;

task('test', array('phpunit.xml'), function() {
    echo sh('phpunit');
});

fileTask('phpunit.xml', array('phpunit.dist.xml'), function() {
    copy('phpunit.dist.xml', 'phpunit.xml');
});
