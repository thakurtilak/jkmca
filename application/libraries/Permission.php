<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *    Permission Class
 *    COPYRIGHT (C) 2008-2009 Haloweb Ltd
 *    http://www.haloweb.co.uk/blog/
 *
 *    Version:    0.9.1
 *    Wiki:       http://codeigniter.com/wiki/Permission_Class/
 *
 *    Description:
 *    The Permission class uses keys in a session to allow or disallow functions
 *    or areas of a site. The keys are stored in a database and this class adds
 *    and/or takes them away. The use of IF statements are required within
 *    controllers and views, please see wiki for code.
 *
 *    Permission is hereby granted, free of charge, to any person obtaining a copy
 *    of this software and associated documentation files (the "Software"), to deal
 *    in the Software without restriction, including without limitation the rights
 *    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *    copies of the Software, and to permit persons to whom the Software is
 *    furnished to do so, subject to the following conditions:
 *
 *    The above copyright notice and this permission notice shall be included in
 *    all copies or substantial portions of the Software.
 *
 *    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *    THE SOFTWARE.
 **/

class Permission {

    // init vars
    var $CI;                        // CI instance
    var $where = array();
    var $set = array();
    var $required = array();

    function __construct()
    {
        // init vars
        $this->CI =& get_instance();

        // set groupID from session (if set)
        $this->roleId = ($this->CI->session->userdata('roleId')) ? $this->CI->session->userdata('roleId') : 0;
    }

    // get permissions from for this roleid
    function get_role_permissions($roleId)
    {

        $this->CI->db->select('key');
        $this->CI->db->from('permissions');
        $this->CI->db->join('permission_map', 'permission_map.permissionID = permissions.permissionID');
        $this->CI->db->where('roleID', $roleId);
        // get role
        $query = $this->CI->db->get();
        // set permissions array and return
        if ($query->num_rows())
        {
            foreach ($query->result_array() as $row)
            {
                $permissions[] = $row['key'];
            }

            return $permissions;
        }
        else
        {
            return false;
        }
    }

    // get permissions from for this roleid
    function get_user_permissions($userId)
    {

        $this->CI->db->select('key');
        $this->CI->db->from(TBL_PERMISSIONS);
        $this->CI->db->join(TBL_USER_PERMISSION_MAP, TBL_USER_PERMISSION_MAP.'.permissionID = '.TBL_PERMISSIONS.'.permissionID');
        $this->CI->db->where('userId', $userId);
        // get role
        $query = $this->CI->db->get();
        // set permissions array and return
        if ($query->num_rows())
        {
            foreach ($query->result_array() as $row)
            {
                $permissions[] = $row['key'];
            }

            return $permissions;
        }
        else
        {
            return false;
        }
    }

    // get all permissions, or permissions from a group for the purposes of listing them in a form
    function get_permissions($roleID = '')
    {
        // select
        $this->CI->db->select('DISTINCT(category)');

        // if groupID is set get on that groupID
        if ($roleID)
        {
            $this->CI->db->where_in('key', $this->get_role_permissions($roleID));
        }

        // order
        $this->CI->db->order_by('category');

        // return
        $query = $this->CI->db->get(TBL_PERMISSIONS);

        if ($query->num_rows())
        {
            $result = $query->result_array();

            foreach($result as $row)
            {
                if ($cat_perms = $this->get_perms_from_cat($row['category']))
                {
                    $permissions[$row['category']] = $cat_perms;
                }
                else
                {
                    $permissions[$row['category']] = 'N/A';
                }
            }
            return $permissions;
        }
        else
        {
            return false;
        }
    }

    // get permissions from a category name, for the purposes of showing permissions inside a category
    function get_perms_from_cat($category = '')
    {
        // where
        if ($category)
        {
            $this->CI->db->where('category', $category);
        }

        // return
        $query = $this->CI->db->get(TBL_PERMISSIONS);

        if ($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    // get the map of keys from a role ID
    function get_permission_map($roleID)
    {
        // grab keys
        $this->CI->db->select('permissionID');

        // where
        $this->CI->db->where('roleID', $roleID);

        // return
        $query = $this->CI->db->get('permission_map');

        if ($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    // get the Roles, for the purposes of displaying them in a form
    function get_roles()
    {
        // where
        $this->CI->db->where('siteID', $this->siteID);

        // return
        $query = $this->CI->db->get(TBL_ROLE_MASTER);

        if ($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    // add permissions to a group, each permission must have an input name of "perm1", or "perm2" etc
    function add_permissions($roleID)
    {
        // delete all permissions on this groupID first
        $this->CI->db->where('roleID', $roleID);
        $this->CI->db->delete('permission_map');

        // get post
        $post = $this->CI->easysite->get_post();
        foreach ($post as $key => $value)
        {
            if (preg_match('/^perm([0-9]+)/i', $key, $matches))
            {
                $this->CI->db->set('roleID', $roleID);
                $this->CI->db->set('permissionID', $matches[1]);
                $this->CI->db->insert('permission_map');
            }
        }

        return true;
    }

    // a group to the permission groups table
    function add_roles($roleName = '')
    {
        if ($roleName)
        {
            $this->CI->db->set('role_name', $roleName);
            $this->CI->db->insert(TBL_ROLE_MASTER);

            return $this->CI->db->insert_id();
        }
        else
        {
            return false;
        }
    }

}