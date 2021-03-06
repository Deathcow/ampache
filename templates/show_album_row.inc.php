<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2015 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */
?>
<td class="cel_play">
    <span class="cel_play_content">&nbsp;</span>
    <div class="cel_play_hover">
    <?php if ($show_direct_play) { ?>
        <?php echo Ajax::button('?page=stream&action=directplay&object_type=album&' . $libitem->get_http_album_query_ids('object_id'), 'play', T_('Play'), 'play_album_' . $libitem->id); ?>
        <?php if (Stream_Playlist::check_autoplay_append()) { ?>
            <?php echo Ajax::button('?page=stream&action=directplay&object_type=album&' . $libitem->get_http_album_query_ids('object_id') . '&append=true', 'play_add', T_('Play last'), 'addplay_album_' . $libitem->id); ?>
        <?php } ?>
        <?php if (Stream_Playlist::check_autoplay_next()) { ?>
            <?php echo Ajax::button('?page=stream&action=directplay&object_type=album&object_id=' . $libitem->id . '&playnext=true', 'play_next', T_('Play next'), 'nextplay_album_' . $libitem->id); ?>
        <?php } ?>
<?php } ?>
    </div>
</td>
<?php
if (Art::is_enabled()) {
    $name = '[' . $libitem->f_artist . '] ' . scrub_out($libitem->full_name);
?>
<td class="cel_cover">
    <?php
    Art::display('album', $libitem->id, $name, 1, AmpConfig::get('web_path') . '/albums.php?action=show&album=' . $libitem->id);
    ?>
</td>
<?php } ?>
<td class="cel_album"><?php echo $libitem->f_link; ?></td>
<td class="cel_add">
    <span class="cel_item_add">
        <?php if ($show_playlist_add) { ?>
            <?php echo Ajax::button('?action=basket&type=album&' . $libitem->get_http_album_query_ids('id'), 'add', T_('Add to temporary playlist'), 'add_album_' . $libitem->id); ?>
            <?php echo Ajax::button('?action=basket&type=album_random&' . $libitem->get_http_album_query_ids('id'), 'random', T_('Random to temporary playlist'), 'random_album_' . $libitem->id); ?>
            <a id="<?php echo 'add_playlist_'.$libitem->id ?>" onclick="showPlaylistDialog(event, 'album', '<?php if (!count($libitem->album_suite)) { echo $libitem->id; } else { echo implode(',', $libitem->album_suite); } ?>')">
                <?php echo UI::get_icon('playlist_add', T_('Add to existing playlist')); ?>
            </a>
        <?php } ?>
    </span>
</td>
<td class="cel_artist"><?php echo (!empty($libitem->f_album_artist_link) ? $libitem->f_album_artist_link : $libitem->f_artist_link); ?></td>
<td class="cel_songs"><?php echo $libitem->song_count; ?></td>
<td class="cel_year"><?php if ($libitem->year > 0) echo $libitem->year; ?></td>
<?php if (AmpConfig::get('show_played_times')) { ?>
<td class="cel_counter"><?php echo $libitem->object_cnt; ?></td>
<?php } ?>
<td class="cel_tags"><?php echo $libitem->f_tags; ?></td>
<?php if (User::is_registered()) { ?>
    <?php if (AmpConfig::get('ratings')) { ?>
    <td class="cel_rating" id="rating_<?php echo $libitem->id; ?>_album"><?php Rating::show($libitem->id, 'album'); ?></td>
    <?php } ?>
    <?php if (AmpConfig::get('userflags')) { ?>
    <td class="cel_userflag" id="userflag_<?php echo $libitem->id; ?>_album"><?php Userflag::show($libitem->id, 'album'); ?></td>
    <?php } ?>
<?php } ?>
<td class="cel_action">
    <?php if (Access::check('interface','25')) { ?>
        <?php if (AmpConfig::get('sociable') && (!$libitem->allow_group_disks || ($libitem->allow_group_disks && !count($libitem->album_suite)))) { ?>
        <a href="<?php echo AmpConfig::get('web_path'); ?>/shout.php?action=show_add_shout&type=album&amp;id=<?php echo $libitem->id; ?>">
            <?php echo UI::get_icon('comment', T_('Post Shout')); ?>
        </a>
        <?php } ?>
        <?php if (AmpConfig::get('share') && (!$libitem->allow_group_disks || ($libitem->allow_group_disks && !count($libitem->album_suite)))) { ?>
            <?php Share::display_ui('album', $libitem->id, false); ?>
        <?php } ?>
    <?php } ?>
    <?php if (Access::check_function('batch_download') && check_can_zip('album')) { ?>
        <a rel="nohtml" href="<?php echo AmpConfig::get('web_path'); ?>/batch.php?action=album&<?php echo $libitem->get_http_album_query_ids('id'); ?>">
            <?php echo UI::get_icon('batch_download', T_('Batch Download')); ?>
        </a>
    <?php } ?>
    <?php if (Access::check('interface','50') && (!$libitem->allow_group_disks || ($libitem->allow_group_disks && !count($libitem->album_suite)))) { ?>
        <a id="<?php echo 'edit_album_'.$libitem->id ?>" onclick="showEditDialog('album_row', '<?php echo $libitem->id ?>', '<?php echo 'edit_album_'.$libitem->id ?>', '<?php echo T_('Album edit') ?>', 'album_')">
            <?php echo UI::get_icon('edit', T_('Edit')); ?>
        </a>
    <?php } ?>
    <?php if (Catalog::can_remove($libitem)) { ?>
    <a id="<?php echo 'delete_album_'.$libitem->id ?>" href="<?php echo AmpConfig::get('web_path'); ?>/albums.php?action=delete&album_id=<?php echo $libitem->id; ?>">
        <?php echo UI::get_icon('delete', T_('Delete')); ?>
    </a>
    <?php } ?>
</td>
