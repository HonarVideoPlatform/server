<?php

/**
 * Base class that represents a row from the 'hshow' table.
 *
 * 
 *
 * @package Core
 * @subpackage model.om
 */
abstract class Basehshow extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        hshowPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        string
	 */
	protected $id;

	/**
	 * The value for the producer_id field.
	 * @var        int
	 */
	protected $producer_id;

	/**
	 * The value for the episode_id field.
	 * @var        string
	 */
	protected $episode_id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the subdomain field.
	 * @var        string
	 */
	protected $subdomain;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the status field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $status;

	/**
	 * The value for the type field.
	 * @var        int
	 */
	protected $type;

	/**
	 * The value for the media_type field.
	 * @var        int
	 */
	protected $media_type;

	/**
	 * The value for the format_type field.
	 * @var        int
	 */
	protected $format_type;

	/**
	 * The value for the language field.
	 * @var        int
	 */
	protected $language;

	/**
	 * The value for the start_date field.
	 * @var        string
	 */
	protected $start_date;

	/**
	 * The value for the end_date field.
	 * @var        string
	 */
	protected $end_date;

	/**
	 * The value for the skin field.
	 * @var        string
	 */
	protected $skin;

	/**
	 * The value for the thumbnail field.
	 * @var        string
	 */
	protected $thumbnail;

	/**
	 * The value for the show_entry_id field.
	 * @var        string
	 */
	protected $show_entry_id;

	/**
	 * The value for the intro_id field.
	 * @var        int
	 */
	protected $intro_id;

	/**
	 * The value for the views field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $views;

	/**
	 * The value for the votes field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $votes;

	/**
	 * The value for the comments field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $comments;

	/**
	 * The value for the favorites field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $favorites;

	/**
	 * The value for the rank field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $rank;

	/**
	 * The value for the entries field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $entries;

	/**
	 * The value for the contributors field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $contributors;

	/**
	 * The value for the subscribers field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $subscribers;

	/**
	 * The value for the number_of_updates field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $number_of_updates;

	/**
	 * The value for the tags field.
	 * @var        string
	 */
	protected $tags;

	/**
	 * The value for the custom_data field.
	 * @var        string
	 */
	protected $custom_data;

	/**
	 * The value for the indexed_custom_data_1 field.
	 * @var        int
	 */
	protected $indexed_custom_data_1;

	/**
	 * The value for the indexed_custom_data_2 field.
	 * @var        int
	 */
	protected $indexed_custom_data_2;

	/**
	 * The value for the indexed_custom_data_3 field.
	 * @var        string
	 */
	protected $indexed_custom_data_3;

	/**
	 * The value for the reoccurence field.
	 * @var        int
	 */
	protected $reoccurence;

	/**
	 * The value for the license_type field.
	 * @var        int
	 */
	protected $license_type;

	/**
	 * The value for the length_in_msecs field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $length_in_msecs;

	/**
	 * The value for the view_permissions field.
	 * @var        int
	 */
	protected $view_permissions;

	/**
	 * The value for the view_password field.
	 * @var        string
	 */
	protected $view_password;

	/**
	 * The value for the contrib_permissions field.
	 * @var        int
	 */
	protected $contrib_permissions;

	/**
	 * The value for the contrib_password field.
	 * @var        string
	 */
	protected $contrib_password;

	/**
	 * The value for the edit_permissions field.
	 * @var        int
	 */
	protected $edit_permissions;

	/**
	 * The value for the edit_password field.
	 * @var        string
	 */
	protected $edit_password;

	/**
	 * The value for the salt field.
	 * @var        string
	 */
	protected $salt;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * The value for the partner_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $partner_id;

	/**
	 * The value for the display_in_search field.
	 * @var        int
	 */
	protected $display_in_search;

	/**
	 * The value for the subp_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $subp_id;

	/**
	 * The value for the permissions field.
	 * @var        string
	 */
	protected $permissions;

	/**
	 * The value for the group_id field.
	 * @var        string
	 */
	protected $group_id;

	/**
	 * The value for the plays field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $plays;

	/**
	 * The value for the partner_data field.
	 * @var        string
	 */
	protected $partner_data;

	/**
	 * The value for the int_id field.
	 * @var        int
	 */
	protected $int_id;

	/**
	 * @var        kuser
	 */
	protected $akuser;

	/**
	 * @var        array kvote[] Collection to store aggregation of kvote objects.
	 */
	protected $collkvotesRelatedByHshowId;

	/**
	 * @var        Criteria The criteria used to select the current contents of collkvotesRelatedByHshowId.
	 */
	private $lastkvoteRelatedByHshowIdCriteria = null;

	/**
	 * @var        array kvote[] Collection to store aggregation of kvote objects.
	 */
	protected $collkvotesRelatedByKuserId;

	/**
	 * @var        Criteria The criteria used to select the current contents of collkvotesRelatedByKuserId.
	 */
	private $lastkvoteRelatedByKuserIdCriteria = null;

	/**
	 * @var        array HshowKuser[] Collection to store aggregation of HshowKuser objects.
	 */
	protected $collHshowKusers;

	/**
	 * @var        Criteria The criteria used to select the current contents of collHshowKusers.
	 */
	private $lastHshowKuserCriteria = null;

	/**
	 * @var        array PuserRole[] Collection to store aggregation of PuserRole objects.
	 */
	protected $collPuserRoles;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPuserRoles.
	 */
	private $lastPuserRoleCriteria = null;

	/**
	 * @var        array roughcutEntry[] Collection to store aggregation of roughcutEntry objects.
	 */
	protected $collroughcutEntrys;

	/**
	 * @var        Criteria The criteria used to select the current contents of collroughcutEntrys.
	 */
	private $lastroughcutEntryCriteria = null;

	/**
	 * @var        array widget[] Collection to store aggregation of widget objects.
	 */
	protected $collwidgets;

	/**
	 * @var        Criteria The criteria used to select the current contents of collwidgets.
	 */
	private $lastwidgetCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to indicate if save action actually affected the db.
	 * @var        boolean
	 */
	protected $objectSaved = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Store columns old values before the changes
	 * @var        array
	 */
	protected $oldColumnsValues = array();
	
	/**
	 * @return array
	 */
	public function getColumnsOldValues()
	{
		return $this->oldColumnsValues;
	}
	
	/**
	 * @return mixed field value or null
	 */
	public function getColumnsOldValue($name)
	{
		if(isset($this->oldColumnsValues[$name]))
			return $this->oldColumnsValues[$name];
			
		return null;
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->status = 0;
		$this->views = 0;
		$this->votes = 0;
		$this->comments = 0;
		$this->favorites = 0;
		$this->rank = 0;
		$this->entries = 0;
		$this->contributors = 0;
		$this->subscribers = 0;
		$this->number_of_updates = 0;
		$this->length_in_msecs = 0;
		$this->partner_id = 0;
		$this->subp_id = 0;
		$this->plays = 0;
	}

	/**
	 * Initializes internal state of Basehshow object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [producer_id] column value.
	 * 
	 * @return     int
	 */
	public function getProducerId()
	{
		return $this->producer_id;
	}

	/**
	 * Get the [episode_id] column value.
	 * 
	 * @return     string
	 */
	public function getEpisodeId()
	{
		return $this->episode_id;
	}

	/**
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [subdomain] column value.
	 * 
	 * @return     string
	 */
	public function getSubdomain()
	{
		return $this->subdomain;
	}

	/**
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Get the [status] column value.
	 * 
	 * @return     int
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Get the [type] column value.
	 * 
	 * @return     int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Get the [media_type] column value.
	 * 
	 * @return     int
	 */
	public function getMediaType()
	{
		return $this->media_type;
	}

	/**
	 * Get the [format_type] column value.
	 * 
	 * @return     int
	 */
	public function getFormatType()
	{
		return $this->format_type;
	}

	/**
	 * Get the [language] column value.
	 * 
	 * @return     int
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * Get the [optionally formatted] temporal [start_date] column value.
	 * 
	 * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
	 * option in order to avoid converstions to integers (which are limited in the dates they can express).
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw unix timestamp integer will be returned.
	 * @return     mixed Formatted date/time value as string or (integer) unix timestamp (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getStartDate($format = '%x')
	{
		if ($this->start_date === null) {
			return null;
		}


		if ($this->start_date === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->start_date);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->start_date, true), $x);
			}
		}

		if ($format === null) {
			// We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
			return (int) $dt->format('U');
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [end_date] column value.
	 * 
	 * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
	 * option in order to avoid converstions to integers (which are limited in the dates they can express).
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw unix timestamp integer will be returned.
	 * @return     mixed Formatted date/time value as string or (integer) unix timestamp (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getEndDate($format = '%x')
	{
		if ($this->end_date === null) {
			return null;
		}


		if ($this->end_date === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->end_date);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->end_date, true), $x);
			}
		}

		if ($format === null) {
			// We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
			return (int) $dt->format('U');
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [skin] column value.
	 * 
	 * @return     string
	 */
	public function getSkin()
	{
		return $this->skin;
	}

	/**
	 * Get the [thumbnail] column value.
	 * 
	 * @return     string
	 */
	public function getThumbnail()
	{
		return $this->thumbnail;
	}

	/**
	 * Get the [show_entry_id] column value.
	 * 
	 * @return     string
	 */
	public function getShowEntryId()
	{
		return $this->show_entry_id;
	}

	/**
	 * Get the [intro_id] column value.
	 * 
	 * @return     int
	 */
	public function getIntroId()
	{
		return $this->intro_id;
	}

	/**
	 * Get the [views] column value.
	 * 
	 * @return     int
	 */
	public function getViews()
	{
		return $this->views;
	}

	/**
	 * Get the [votes] column value.
	 * 
	 * @return     int
	 */
	public function getVotes()
	{
		return $this->votes;
	}

	/**
	 * Get the [comments] column value.
	 * 
	 * @return     int
	 */
	public function getComments()
	{
		return $this->comments;
	}

	/**
	 * Get the [favorites] column value.
	 * 
	 * @return     int
	 */
	public function getFavorites()
	{
		return $this->favorites;
	}

	/**
	 * Get the [rank] column value.
	 * 
	 * @return     int
	 */
	public function getRank()
	{
		return $this->rank;
	}

	/**
	 * Get the [entries] column value.
	 * 
	 * @return     int
	 */
	public function getEntries()
	{
		return $this->entries;
	}

	/**
	 * Get the [contributors] column value.
	 * 
	 * @return     int
	 */
	public function getContributors()
	{
		return $this->contributors;
	}

	/**
	 * Get the [subscribers] column value.
	 * 
	 * @return     int
	 */
	public function getSubscribers()
	{
		return $this->subscribers;
	}

	/**
	 * Get the [number_of_updates] column value.
	 * 
	 * @return     int
	 */
	public function getNumberOfUpdates()
	{
		return $this->number_of_updates;
	}

	/**
	 * Get the [tags] column value.
	 * 
	 * @return     string
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * Get the [custom_data] column value.
	 * 
	 * @return     string
	 */
	public function getCustomData()
	{
		return $this->custom_data;
	}

	/**
	 * Get the [indexed_custom_data_1] column value.
	 * 
	 * @return     int
	 */
	public function getIndexedCustomData1()
	{
		return $this->indexed_custom_data_1;
	}

	/**
	 * Get the [indexed_custom_data_2] column value.
	 * 
	 * @return     int
	 */
	public function getIndexedCustomData2()
	{
		return $this->indexed_custom_data_2;
	}

	/**
	 * Get the [indexed_custom_data_3] column value.
	 * 
	 * @return     string
	 */
	public function getIndexedCustomData3()
	{
		return $this->indexed_custom_data_3;
	}

	/**
	 * Get the [reoccurence] column value.
	 * 
	 * @return     int
	 */
	public function getReoccurence()
	{
		return $this->reoccurence;
	}

	/**
	 * Get the [license_type] column value.
	 * 
	 * @return     int
	 */
	public function getLicenseType()
	{
		return $this->license_type;
	}

	/**
	 * Get the [length_in_msecs] column value.
	 * 
	 * @return     int
	 */
	public function getLengthInMsecs()
	{
		return $this->length_in_msecs;
	}

	/**
	 * Get the [view_permissions] column value.
	 * 
	 * @return     int
	 */
	public function getViewPermissions()
	{
		return $this->view_permissions;
	}

	/**
	 * Get the [view_password] column value.
	 * 
	 * @return     string
	 */
	public function getViewPassword()
	{
		return $this->view_password;
	}

	/**
	 * Get the [contrib_permissions] column value.
	 * 
	 * @return     int
	 */
	public function getContribPermissions()
	{
		return $this->contrib_permissions;
	}

	/**
	 * Get the [contrib_password] column value.
	 * 
	 * @return     string
	 */
	public function getContribPassword()
	{
		return $this->contrib_password;
	}

	/**
	 * Get the [edit_permissions] column value.
	 * 
	 * @return     int
	 */
	public function getEditPermissions()
	{
		return $this->edit_permissions;
	}

	/**
	 * Get the [edit_password] column value.
	 * 
	 * @return     string
	 */
	public function getEditPassword()
	{
		return $this->edit_password;
	}

	/**
	 * Get the [salt] column value.
	 * 
	 * @return     string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
	 * option in order to avoid converstions to integers (which are limited in the dates they can express).
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw unix timestamp integer will be returned.
	 * @return     mixed Formatted date/time value as string or (integer) unix timestamp (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
			return (int) $dt->format('U');
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
	 * option in order to avoid converstions to integers (which are limited in the dates they can express).
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw unix timestamp integer will be returned.
	 * @return     mixed Formatted date/time value as string or (integer) unix timestamp (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
			return (int) $dt->format('U');
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [partner_id] column value.
	 * 
	 * @return     int
	 */
	public function getPartnerId()
	{
		return $this->partner_id;
	}

	/**
	 * Get the [display_in_search] column value.
	 * 
	 * @return     int
	 */
	public function getDisplayInSearch()
	{
		return $this->display_in_search;
	}

	/**
	 * Get the [subp_id] column value.
	 * 
	 * @return     int
	 */
	public function getSubpId()
	{
		return $this->subp_id;
	}

	/**
	 * Get the [permissions] column value.
	 * 
	 * @return     string
	 */
	public function getPermissions()
	{
		return $this->permissions;
	}

	/**
	 * Get the [group_id] column value.
	 * 
	 * @return     string
	 */
	public function getGroupId()
	{
		return $this->group_id;
	}

	/**
	 * Get the [plays] column value.
	 * 
	 * @return     int
	 */
	public function getPlays()
	{
		return $this->plays;
	}

	/**
	 * Get the [partner_data] column value.
	 * 
	 * @return     string
	 */
	public function getPartnerData()
	{
		return $this->partner_data;
	}

	/**
	 * Get the [int_id] column value.
	 * 
	 * @return     int
	 */
	public function getIntId()
	{
		return $this->int_id;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::ID]))
			$this->oldColumnsValues[hshowPeer::ID] = $this->id;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = hshowPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [producer_id] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setProducerId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::PRODUCER_ID]))
			$this->oldColumnsValues[hshowPeer::PRODUCER_ID] = $this->producer_id;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->producer_id !== $v) {
			$this->producer_id = $v;
			$this->modifiedColumns[] = hshowPeer::PRODUCER_ID;
		}

		if ($this->akuser !== null && $this->akuser->getId() !== $v) {
			$this->akuser = null;
		}

		return $this;
	} // setProducerId()

	/**
	 * Set the value of [episode_id] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setEpisodeId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::EPISODE_ID]))
			$this->oldColumnsValues[hshowPeer::EPISODE_ID] = $this->episode_id;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->episode_id !== $v) {
			$this->episode_id = $v;
			$this->modifiedColumns[] = hshowPeer::EPISODE_ID;
		}

		return $this;
	} // setEpisodeId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::NAME]))
			$this->oldColumnsValues[hshowPeer::NAME] = $this->name;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = hshowPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [subdomain] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setSubdomain($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::SUBDOMAIN]))
			$this->oldColumnsValues[hshowPeer::SUBDOMAIN] = $this->subdomain;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->subdomain !== $v) {
			$this->subdomain = $v;
			$this->modifiedColumns[] = hshowPeer::SUBDOMAIN;
		}

		return $this;
	} // setSubdomain()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::DESCRIPTION]))
			$this->oldColumnsValues[hshowPeer::DESCRIPTION] = $this->description;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = hshowPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Set the value of [status] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setStatus($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::STATUS]))
			$this->oldColumnsValues[hshowPeer::STATUS] = $this->status;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->status !== $v || $this->isNew()) {
			$this->status = $v;
			$this->modifiedColumns[] = hshowPeer::STATUS;
		}

		return $this;
	} // setStatus()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setType($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::TYPE]))
			$this->oldColumnsValues[hshowPeer::TYPE] = $this->type;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = hshowPeer::TYPE;
		}

		return $this;
	} // setType()

	/**
	 * Set the value of [media_type] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setMediaType($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::MEDIA_TYPE]))
			$this->oldColumnsValues[hshowPeer::MEDIA_TYPE] = $this->media_type;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->media_type !== $v) {
			$this->media_type = $v;
			$this->modifiedColumns[] = hshowPeer::MEDIA_TYPE;
		}

		return $this;
	} // setMediaType()

	/**
	 * Set the value of [format_type] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setFormatType($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::FORMAT_TYPE]))
			$this->oldColumnsValues[hshowPeer::FORMAT_TYPE] = $this->format_type;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->format_type !== $v) {
			$this->format_type = $v;
			$this->modifiedColumns[] = hshowPeer::FORMAT_TYPE;
		}

		return $this;
	} // setFormatType()

	/**
	 * Set the value of [language] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setLanguage($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::LANGUAGE]))
			$this->oldColumnsValues[hshowPeer::LANGUAGE] = $this->language;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->language !== $v) {
			$this->language = $v;
			$this->modifiedColumns[] = hshowPeer::LANGUAGE;
		}

		return $this;
	} // setLanguage()

	/**
	 * Sets the value of [start_date] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setStartDate($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::START_DATE]))
			$this->oldColumnsValues[hshowPeer::START_DATE] = $this->start_date;

		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->start_date !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->start_date !== null && $tmpDt = new DateTime($this->start_date)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->start_date = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = hshowPeer::START_DATE;
			}
		} // if either are not null

		return $this;
	} // setStartDate()

	/**
	 * Sets the value of [end_date] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setEndDate($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::END_DATE]))
			$this->oldColumnsValues[hshowPeer::END_DATE] = $this->end_date;

		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->end_date !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->end_date !== null && $tmpDt = new DateTime($this->end_date)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->end_date = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = hshowPeer::END_DATE;
			}
		} // if either are not null

		return $this;
	} // setEndDate()

	/**
	 * Set the value of [skin] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setSkin($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::SKIN]))
			$this->oldColumnsValues[hshowPeer::SKIN] = $this->skin;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->skin !== $v) {
			$this->skin = $v;
			$this->modifiedColumns[] = hshowPeer::SKIN;
		}

		return $this;
	} // setSkin()

	/**
	 * Set the value of [thumbnail] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setThumbnail($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::THUMBNAIL]))
			$this->oldColumnsValues[hshowPeer::THUMBNAIL] = $this->thumbnail;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->thumbnail !== $v) {
			$this->thumbnail = $v;
			$this->modifiedColumns[] = hshowPeer::THUMBNAIL;
		}

		return $this;
	} // setThumbnail()

	/**
	 * Set the value of [show_entry_id] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setShowEntryId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::SHOW_ENTRY_ID]))
			$this->oldColumnsValues[hshowPeer::SHOW_ENTRY_ID] = $this->show_entry_id;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->show_entry_id !== $v) {
			$this->show_entry_id = $v;
			$this->modifiedColumns[] = hshowPeer::SHOW_ENTRY_ID;
		}

		return $this;
	} // setShowEntryId()

	/**
	 * Set the value of [intro_id] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setIntroId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::INTRO_ID]))
			$this->oldColumnsValues[hshowPeer::INTRO_ID] = $this->intro_id;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->intro_id !== $v) {
			$this->intro_id = $v;
			$this->modifiedColumns[] = hshowPeer::INTRO_ID;
		}

		return $this;
	} // setIntroId()

	/**
	 * Set the value of [views] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setViews($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::VIEWS]))
			$this->oldColumnsValues[hshowPeer::VIEWS] = $this->views;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->views !== $v || $this->isNew()) {
			$this->views = $v;
			$this->modifiedColumns[] = hshowPeer::VIEWS;
		}

		return $this;
	} // setViews()

	/**
	 * Set the value of [votes] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setVotes($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::VOTES]))
			$this->oldColumnsValues[hshowPeer::VOTES] = $this->votes;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->votes !== $v || $this->isNew()) {
			$this->votes = $v;
			$this->modifiedColumns[] = hshowPeer::VOTES;
		}

		return $this;
	} // setVotes()

	/**
	 * Set the value of [comments] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setComments($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::COMMENTS]))
			$this->oldColumnsValues[hshowPeer::COMMENTS] = $this->comments;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->comments !== $v || $this->isNew()) {
			$this->comments = $v;
			$this->modifiedColumns[] = hshowPeer::COMMENTS;
		}

		return $this;
	} // setComments()

	/**
	 * Set the value of [favorites] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setFavorites($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::FAVORITES]))
			$this->oldColumnsValues[hshowPeer::FAVORITES] = $this->favorites;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->favorites !== $v || $this->isNew()) {
			$this->favorites = $v;
			$this->modifiedColumns[] = hshowPeer::FAVORITES;
		}

		return $this;
	} // setFavorites()

	/**
	 * Set the value of [rank] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setRank($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::RANK]))
			$this->oldColumnsValues[hshowPeer::RANK] = $this->rank;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->rank !== $v || $this->isNew()) {
			$this->rank = $v;
			$this->modifiedColumns[] = hshowPeer::RANK;
		}

		return $this;
	} // setRank()

	/**
	 * Set the value of [entries] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setEntries($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::ENTRIES]))
			$this->oldColumnsValues[hshowPeer::ENTRIES] = $this->entries;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->entries !== $v || $this->isNew()) {
			$this->entries = $v;
			$this->modifiedColumns[] = hshowPeer::ENTRIES;
		}

		return $this;
	} // setEntries()

	/**
	 * Set the value of [contributors] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setContributors($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::CONTRIBUTORS]))
			$this->oldColumnsValues[hshowPeer::CONTRIBUTORS] = $this->contributors;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->contributors !== $v || $this->isNew()) {
			$this->contributors = $v;
			$this->modifiedColumns[] = hshowPeer::CONTRIBUTORS;
		}

		return $this;
	} // setContributors()

	/**
	 * Set the value of [subscribers] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setSubscribers($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::SUBSCRIBERS]))
			$this->oldColumnsValues[hshowPeer::SUBSCRIBERS] = $this->subscribers;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->subscribers !== $v || $this->isNew()) {
			$this->subscribers = $v;
			$this->modifiedColumns[] = hshowPeer::SUBSCRIBERS;
		}

		return $this;
	} // setSubscribers()

	/**
	 * Set the value of [number_of_updates] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setNumberOfUpdates($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::NUMBER_OF_UPDATES]))
			$this->oldColumnsValues[hshowPeer::NUMBER_OF_UPDATES] = $this->number_of_updates;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->number_of_updates !== $v || $this->isNew()) {
			$this->number_of_updates = $v;
			$this->modifiedColumns[] = hshowPeer::NUMBER_OF_UPDATES;
		}

		return $this;
	} // setNumberOfUpdates()

	/**
	 * Set the value of [tags] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setTags($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::TAGS]))
			$this->oldColumnsValues[hshowPeer::TAGS] = $this->tags;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tags !== $v) {
			$this->tags = $v;
			$this->modifiedColumns[] = hshowPeer::TAGS;
		}

		return $this;
	} // setTags()

	/**
	 * Set the value of [custom_data] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setCustomData($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->custom_data !== $v) {
			$this->custom_data = $v;
			$this->modifiedColumns[] = hshowPeer::CUSTOM_DATA;
		}

		return $this;
	} // setCustomData()

	/**
	 * Set the value of [indexed_custom_data_1] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setIndexedCustomData1($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::INDEXED_CUSTOM_DATA_1]))
			$this->oldColumnsValues[hshowPeer::INDEXED_CUSTOM_DATA_1] = $this->indexed_custom_data_1;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->indexed_custom_data_1 !== $v) {
			$this->indexed_custom_data_1 = $v;
			$this->modifiedColumns[] = hshowPeer::INDEXED_CUSTOM_DATA_1;
		}

		return $this;
	} // setIndexedCustomData1()

	/**
	 * Set the value of [indexed_custom_data_2] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setIndexedCustomData2($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::INDEXED_CUSTOM_DATA_2]))
			$this->oldColumnsValues[hshowPeer::INDEXED_CUSTOM_DATA_2] = $this->indexed_custom_data_2;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->indexed_custom_data_2 !== $v) {
			$this->indexed_custom_data_2 = $v;
			$this->modifiedColumns[] = hshowPeer::INDEXED_CUSTOM_DATA_2;
		}

		return $this;
	} // setIndexedCustomData2()

	/**
	 * Set the value of [indexed_custom_data_3] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setIndexedCustomData3($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::INDEXED_CUSTOM_DATA_3]))
			$this->oldColumnsValues[hshowPeer::INDEXED_CUSTOM_DATA_3] = $this->indexed_custom_data_3;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->indexed_custom_data_3 !== $v) {
			$this->indexed_custom_data_3 = $v;
			$this->modifiedColumns[] = hshowPeer::INDEXED_CUSTOM_DATA_3;
		}

		return $this;
	} // setIndexedCustomData3()

	/**
	 * Set the value of [reoccurence] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setReoccurence($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::REOCCURENCE]))
			$this->oldColumnsValues[hshowPeer::REOCCURENCE] = $this->reoccurence;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->reoccurence !== $v) {
			$this->reoccurence = $v;
			$this->modifiedColumns[] = hshowPeer::REOCCURENCE;
		}

		return $this;
	} // setReoccurence()

	/**
	 * Set the value of [license_type] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setLicenseType($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::LICENSE_TYPE]))
			$this->oldColumnsValues[hshowPeer::LICENSE_TYPE] = $this->license_type;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->license_type !== $v) {
			$this->license_type = $v;
			$this->modifiedColumns[] = hshowPeer::LICENSE_TYPE;
		}

		return $this;
	} // setLicenseType()

	/**
	 * Set the value of [length_in_msecs] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setLengthInMsecs($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::LENGTH_IN_MSECS]))
			$this->oldColumnsValues[hshowPeer::LENGTH_IN_MSECS] = $this->length_in_msecs;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->length_in_msecs !== $v || $this->isNew()) {
			$this->length_in_msecs = $v;
			$this->modifiedColumns[] = hshowPeer::LENGTH_IN_MSECS;
		}

		return $this;
	} // setLengthInMsecs()

	/**
	 * Set the value of [view_permissions] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setViewPermissions($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::VIEW_PERMISSIONS]))
			$this->oldColumnsValues[hshowPeer::VIEW_PERMISSIONS] = $this->view_permissions;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->view_permissions !== $v) {
			$this->view_permissions = $v;
			$this->modifiedColumns[] = hshowPeer::VIEW_PERMISSIONS;
		}

		return $this;
	} // setViewPermissions()

	/**
	 * Set the value of [view_password] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setViewPassword($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::VIEW_PASSWORD]))
			$this->oldColumnsValues[hshowPeer::VIEW_PASSWORD] = $this->view_password;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->view_password !== $v) {
			$this->view_password = $v;
			$this->modifiedColumns[] = hshowPeer::VIEW_PASSWORD;
		}

		return $this;
	} // setViewPassword()

	/**
	 * Set the value of [contrib_permissions] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setContribPermissions($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::CONTRIB_PERMISSIONS]))
			$this->oldColumnsValues[hshowPeer::CONTRIB_PERMISSIONS] = $this->contrib_permissions;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->contrib_permissions !== $v) {
			$this->contrib_permissions = $v;
			$this->modifiedColumns[] = hshowPeer::CONTRIB_PERMISSIONS;
		}

		return $this;
	} // setContribPermissions()

	/**
	 * Set the value of [contrib_password] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setContribPassword($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::CONTRIB_PASSWORD]))
			$this->oldColumnsValues[hshowPeer::CONTRIB_PASSWORD] = $this->contrib_password;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->contrib_password !== $v) {
			$this->contrib_password = $v;
			$this->modifiedColumns[] = hshowPeer::CONTRIB_PASSWORD;
		}

		return $this;
	} // setContribPassword()

	/**
	 * Set the value of [edit_permissions] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setEditPermissions($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::EDIT_PERMISSIONS]))
			$this->oldColumnsValues[hshowPeer::EDIT_PERMISSIONS] = $this->edit_permissions;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->edit_permissions !== $v) {
			$this->edit_permissions = $v;
			$this->modifiedColumns[] = hshowPeer::EDIT_PERMISSIONS;
		}

		return $this;
	} // setEditPermissions()

	/**
	 * Set the value of [edit_password] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setEditPassword($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::EDIT_PASSWORD]))
			$this->oldColumnsValues[hshowPeer::EDIT_PASSWORD] = $this->edit_password;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->edit_password !== $v) {
			$this->edit_password = $v;
			$this->modifiedColumns[] = hshowPeer::EDIT_PASSWORD;
		}

		return $this;
	} // setEditPassword()

	/**
	 * Set the value of [salt] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setSalt($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::SALT]))
			$this->oldColumnsValues[hshowPeer::SALT] = $this->salt;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->salt !== $v) {
			$this->salt = $v;
			$this->modifiedColumns[] = hshowPeer::SALT;
		}

		return $this;
	} // setSalt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = hshowPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = hshowPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Set the value of [partner_id] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setPartnerId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::PARTNER_ID]))
			$this->oldColumnsValues[hshowPeer::PARTNER_ID] = $this->partner_id;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->partner_id !== $v || $this->isNew()) {
			$this->partner_id = $v;
			$this->modifiedColumns[] = hshowPeer::PARTNER_ID;
		}

		return $this;
	} // setPartnerId()

	/**
	 * Set the value of [display_in_search] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setDisplayInSearch($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::DISPLAY_IN_SEARCH]))
			$this->oldColumnsValues[hshowPeer::DISPLAY_IN_SEARCH] = $this->display_in_search;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->display_in_search !== $v) {
			$this->display_in_search = $v;
			$this->modifiedColumns[] = hshowPeer::DISPLAY_IN_SEARCH;
		}

		return $this;
	} // setDisplayInSearch()

	/**
	 * Set the value of [subp_id] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setSubpId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::SUBP_ID]))
			$this->oldColumnsValues[hshowPeer::SUBP_ID] = $this->subp_id;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->subp_id !== $v || $this->isNew()) {
			$this->subp_id = $v;
			$this->modifiedColumns[] = hshowPeer::SUBP_ID;
		}

		return $this;
	} // setSubpId()

	/**
	 * Set the value of [permissions] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setPermissions($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::PERMISSIONS]))
			$this->oldColumnsValues[hshowPeer::PERMISSIONS] = $this->permissions;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->permissions !== $v) {
			$this->permissions = $v;
			$this->modifiedColumns[] = hshowPeer::PERMISSIONS;
		}

		return $this;
	} // setPermissions()

	/**
	 * Set the value of [group_id] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setGroupId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::GROUP_ID]))
			$this->oldColumnsValues[hshowPeer::GROUP_ID] = $this->group_id;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->group_id !== $v) {
			$this->group_id = $v;
			$this->modifiedColumns[] = hshowPeer::GROUP_ID;
		}

		return $this;
	} // setGroupId()

	/**
	 * Set the value of [plays] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setPlays($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::PLAYS]))
			$this->oldColumnsValues[hshowPeer::PLAYS] = $this->plays;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->plays !== $v || $this->isNew()) {
			$this->plays = $v;
			$this->modifiedColumns[] = hshowPeer::PLAYS;
		}

		return $this;
	} // setPlays()

	/**
	 * Set the value of [partner_data] column.
	 * 
	 * @param      string $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setPartnerData($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::PARTNER_DATA]))
			$this->oldColumnsValues[hshowPeer::PARTNER_DATA] = $this->partner_data;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->partner_data !== $v) {
			$this->partner_data = $v;
			$this->modifiedColumns[] = hshowPeer::PARTNER_DATA;
		}

		return $this;
	} // setPartnerData()

	/**
	 * Set the value of [int_id] column.
	 * 
	 * @param      int $v new value
	 * @return     hshow The current object (for fluent API support)
	 */
	public function setIntId($v)
	{
		if(!isset($this->oldColumnsValues[hshowPeer::INT_ID]))
			$this->oldColumnsValues[hshowPeer::INT_ID] = $this->int_id;

		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->int_id !== $v) {
			$this->int_id = $v;
			$this->modifiedColumns[] = hshowPeer::INT_ID;
		}

		return $this;
	} // setIntId()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->status !== 0) {
				return false;
			}

			if ($this->views !== 0) {
				return false;
			}

			if ($this->votes !== 0) {
				return false;
			}

			if ($this->comments !== 0) {
				return false;
			}

			if ($this->favorites !== 0) {
				return false;
			}

			if ($this->rank !== 0) {
				return false;
			}

			if ($this->entries !== 0) {
				return false;
			}

			if ($this->contributors !== 0) {
				return false;
			}

			if ($this->subscribers !== 0) {
				return false;
			}

			if ($this->number_of_updates !== 0) {
				return false;
			}

			if ($this->length_in_msecs !== 0) {
				return false;
			}

			if ($this->partner_id !== 0) {
				return false;
			}

			if ($this->subp_id !== 0) {
				return false;
			}

			if ($this->plays !== 0) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		// Nullify cached objects
		$this->m_custom_data = null;
		
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
			$this->producer_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->episode_id = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->subdomain = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->description = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->status = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->type = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->media_type = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->format_type = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->language = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
			$this->start_date = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->end_date = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->skin = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->thumbnail = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
			$this->show_entry_id = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
			$this->intro_id = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
			$this->views = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
			$this->votes = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
			$this->comments = ($row[$startcol + 19] !== null) ? (int) $row[$startcol + 19] : null;
			$this->favorites = ($row[$startcol + 20] !== null) ? (int) $row[$startcol + 20] : null;
			$this->rank = ($row[$startcol + 21] !== null) ? (int) $row[$startcol + 21] : null;
			$this->entries = ($row[$startcol + 22] !== null) ? (int) $row[$startcol + 22] : null;
			$this->contributors = ($row[$startcol + 23] !== null) ? (int) $row[$startcol + 23] : null;
			$this->subscribers = ($row[$startcol + 24] !== null) ? (int) $row[$startcol + 24] : null;
			$this->number_of_updates = ($row[$startcol + 25] !== null) ? (int) $row[$startcol + 25] : null;
			$this->tags = ($row[$startcol + 26] !== null) ? (string) $row[$startcol + 26] : null;
			$this->custom_data = ($row[$startcol + 27] !== null) ? (string) $row[$startcol + 27] : null;
			$this->indexed_custom_data_1 = ($row[$startcol + 28] !== null) ? (int) $row[$startcol + 28] : null;
			$this->indexed_custom_data_2 = ($row[$startcol + 29] !== null) ? (int) $row[$startcol + 29] : null;
			$this->indexed_custom_data_3 = ($row[$startcol + 30] !== null) ? (string) $row[$startcol + 30] : null;
			$this->reoccurence = ($row[$startcol + 31] !== null) ? (int) $row[$startcol + 31] : null;
			$this->license_type = ($row[$startcol + 32] !== null) ? (int) $row[$startcol + 32] : null;
			$this->length_in_msecs = ($row[$startcol + 33] !== null) ? (int) $row[$startcol + 33] : null;
			$this->view_permissions = ($row[$startcol + 34] !== null) ? (int) $row[$startcol + 34] : null;
			$this->view_password = ($row[$startcol + 35] !== null) ? (string) $row[$startcol + 35] : null;
			$this->contrib_permissions = ($row[$startcol + 36] !== null) ? (int) $row[$startcol + 36] : null;
			$this->contrib_password = ($row[$startcol + 37] !== null) ? (string) $row[$startcol + 37] : null;
			$this->edit_permissions = ($row[$startcol + 38] !== null) ? (int) $row[$startcol + 38] : null;
			$this->edit_password = ($row[$startcol + 39] !== null) ? (string) $row[$startcol + 39] : null;
			$this->salt = ($row[$startcol + 40] !== null) ? (string) $row[$startcol + 40] : null;
			$this->created_at = ($row[$startcol + 41] !== null) ? (string) $row[$startcol + 41] : null;
			$this->updated_at = ($row[$startcol + 42] !== null) ? (string) $row[$startcol + 42] : null;
			$this->partner_id = ($row[$startcol + 43] !== null) ? (int) $row[$startcol + 43] : null;
			$this->display_in_search = ($row[$startcol + 44] !== null) ? (int) $row[$startcol + 44] : null;
			$this->subp_id = ($row[$startcol + 45] !== null) ? (int) $row[$startcol + 45] : null;
			$this->permissions = ($row[$startcol + 46] !== null) ? (string) $row[$startcol + 46] : null;
			$this->group_id = ($row[$startcol + 47] !== null) ? (string) $row[$startcol + 47] : null;
			$this->plays = ($row[$startcol + 48] !== null) ? (int) $row[$startcol + 48] : null;
			$this->partner_data = ($row[$startcol + 49] !== null) ? (string) $row[$startcol + 49] : null;
			$this->int_id = ($row[$startcol + 50] !== null) ? (int) $row[$startcol + 50] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 51; // 51 = hshowPeer::NUM_COLUMNS - hshowPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating hshow object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->akuser !== null && $this->producer_id !== $this->akuser->getId()) {
			$this->akuser = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(hshowPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		hshowPeer::setUseCriteriaFilter(false);
		$criteria = $this->buildPkeyCriteria();
		hshowPeer::addSelectColumns($criteria);
		$stmt = BasePeer::doSelect($criteria, $con);
		hshowPeer::setUseCriteriaFilter(true);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->akuser = null;
			$this->collkvotesRelatedByHshowId = null;
			$this->lastkvoteRelatedByHshowIdCriteria = null;

			$this->collkvotesRelatedByKuserId = null;
			$this->lastkvoteRelatedByKuserIdCriteria = null;

			$this->collHshowKusers = null;
			$this->lastHshowKuserCriteria = null;

			$this->collPuserRoles = null;
			$this->lastPuserRoleCriteria = null;

			$this->collroughcutEntrys = null;
			$this->lastroughcutEntryCriteria = null;

			$this->collwidgets = null;
			$this->lastwidgetCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(hshowPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			if ($ret) {
				hshowPeer::doDelete($this, $con);
				$this->postDelete($con);
				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * Since this table was configured to reload rows on insert, the object will
	 * be reloaded from the database if an INSERT operation is performed (unless
	 * the $skipReload parameter is TRUE).
	 *
	 * @param      PropelPDO $con
	 * @param      boolean $skipReload Whether to skip the reload for this object from database.
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null, $skipReload = false)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(hshowPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			
			if (!$ret || !$this->isModified()) {
				$con->commit();
				return 0;
			}
			
			for ($retries = 1; $retries < KalturaPDO::SAVE_MAX_RETRIES; $retries++)
			{
               $affectedRows = $this->doSave($con);
                if ($affectedRows || !$this->isColumnModified(hshowPeer::CUSTOM_DATA)) //ask if custom_data wasn't modified to avoid retry with atomic column 
                	break;

                KalturaLog::debug("was unable to save! retrying for the $retries time");
                $criteria = $this->buildPkeyCriteria();
				$criteria->addSelectColumn(hshowPeer::CUSTOM_DATA);
                $stmt = BasePeer::doSelect($criteria, $con);
                $cutsomDataArr = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $newCustomData = $cutsomDataArr[0];

                $this->custom_data_md5 = is_null($newCustomData) ? null : md5($newCustomData);

                $valuesToChangeTo = $this->m_custom_data->toArray();
				$this->m_custom_data = myCustomData::fromString($newCustomData); 

				//set custom data column values we wanted to change to
				$validUpdate = true;
				$atomicCustomDataFields = hshowPeer::getAtomicCustomDataFields();
			 	foreach ($this->oldCustomDataValues as $namespace => $namespaceValues){
                	foreach($namespaceValues as $name => $oldValue)
					{
						$atomicField = false;
						if($namespace) {
							$atomicField = array_key_exists($namespace, $atomicCustomDataFields) && in_array($name, $atomicCustomDataFields[$namespace]);
						} else {
							$atomicField = in_array($name, $atomicCustomDataFields);
						}
						if($atomicField) {
							$dbValue = $this->m_custom_data->get($name, $namespace);
							if($oldValue != $dbValue) {
								$validUpdate = false;
								break;
							}
						}
						
						$newValue = null;
						if ($namespace)
						{
							if (isset ($valuesToChangeTo[$namespace][$name]))
								$newValue = $valuesToChangeTo[$namespace][$name];
						}
						else
						{ 
							$newValue = $valuesToChangeTo[$name];
						}
		
						if (is_null($newValue)) {
							$this->removeFromCustomData($name, $namespace);
						}
						else {
							$this->putInCustomData($name, $newValue, $namespace);
						}
					}
				}
                   
				if(!$validUpdate) 
					break;
					                   
				$this->setCustomData($this->m_custom_data->toString());
			}

			if ($isInsert) {
				$this->postInsert($con);
			} else {
				$this->postUpdate($con);
			}
			$this->postSave($con);
			hshowPeer::addInstanceToPool($this);
			
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}
	
	public function wasObjectSaved()
	{
		return $this->objectSaved;
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @param      boolean $skipReload Whether to skip the reload for this object from database.
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con, $skipReload = false)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			$reloadObject = false;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->akuser !== null) {
				if ($this->akuser->isModified() || $this->akuser->isNew()) {
					$affectedRows += $this->akuser->save($con);
				}
				$this->setkuser($this->akuser);
			}


			// If this object has been modified, then save it to the database.
			$this->objectSaved = false;
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = hshowPeer::doInsert($this, $con);
					if (!$skipReload) {
						$reloadObject = true;
					}
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
					$this->objectSaved = true;
				} else {
					$affectedObjects = hshowPeer::doUpdate($this, $con);
					if($affectedObjects)
						$this->objectSaved = true;
						
					$affectedRows += $affectedObjects;
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collkvotesRelatedByHshowId !== null) {
				foreach ($this->collkvotesRelatedByHshowId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collkvotesRelatedByKuserId !== null) {
				foreach ($this->collkvotesRelatedByKuserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collHshowKusers !== null) {
				foreach ($this->collHshowKusers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPuserRoles !== null) {
				foreach ($this->collPuserRoles as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collroughcutEntrys !== null) {
				foreach ($this->collroughcutEntrys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collwidgets !== null) {
				foreach ($this->collwidgets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

			if ($reloadObject) {
				$this->reload($con);
			}

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Override in order to use the query cache.
	 * Cache invalidation keys are used to determine when cached queries are valid.
	 * Before returning a query result from the cache, the time of the cached query
	 * is compared to the time saved in the invalidation key.
	 * A cached query will only be used if it's newer than the matching invalidation key.
	 *  
	 * @return     array Array of keys that will should be updated when this object is modified.
	 */
	public function getCacheInvalidationKeys()
	{
		return array();
	}
		
	/**
	 * Code to be run before persisting the object
	 * @param PropelPDO $con
	 * @return boolean
	 */
	public function preSave(PropelPDO $con = null)
	{
		$this->setCustomDataObj();
    	
		return parent::preSave($con);
	}

	/**
	 * Code to be run after persisting the object
	 * @param PropelPDO $con
	 */
	public function postSave(PropelPDO $con = null) 
	{
		kEventsManager::raiseEvent(new kObjectSavedEvent($this));
		$this->oldColumnsValues = array();
		$this->oldCustomDataValues = array();
    	 
		parent::postSave($con);
	}
	
	/**
	 * Code to be run before inserting to database
	 * @param PropelPDO $con
	 * @return boolean
	 */
	public function preInsert(PropelPDO $con = null)
	{
		$this->setCreatedAt(time());
		$this->setUpdatedAt(time());
		return parent::preInsert($con);
	}
	
	/**
	 * Code to be run after inserting to database
	 * @param PropelPDO $con 
	 */
	public function postInsert(PropelPDO $con = null)
	{
		kQueryCache::invalidateQueryCache($this);
		
		kEventsManager::raiseEvent(new kObjectCreatedEvent($this));
		
		if($this->copiedFrom)
			kEventsManager::raiseEvent(new kObjectCopiedEvent($this->copiedFrom, $this));
		
		parent::postInsert($con);
	}

	/**
	 * Code to be run after updating the object in database
	 * @param PropelPDO $con
	 */
	public function postUpdate(PropelPDO $con = null)
	{
		if ($this->alreadyInSave)
		{
			return;
		}
	
		if($this->isModified())
		{
			kQueryCache::invalidateQueryCache($this);
			$modifiedColumns = $this->tempModifiedColumns;
			$modifiedColumns[kObjectChangedEvent::CUSTOM_DATA_OLD_VALUES] = $this->oldCustomDataValues;
			kEventsManager::raiseEvent(new kObjectChangedEvent($this, $modifiedColumns));
		}
			
		$this->tempModifiedColumns = array();
		
		parent::postUpdate($con);
	}
	/**
	 * Saves the modified columns temporarily while saving
	 * @var array
	 */
	private $tempModifiedColumns = array();
	
	/**
	 * Returns whether the object has been modified.
	 *
	 * @return     boolean True if the object has been modified.
	 */
	public function isModified()
	{
		if(!empty($this->tempModifiedColumns))
			return true;
			
		return !empty($this->modifiedColumns);
	}

	/**
	 * Has specified column been modified?
	 *
	 * @param      string $col
	 * @return     boolean True if $col has been modified.
	 */
	public function isColumnModified($col)
	{
		if(in_array($col, $this->tempModifiedColumns))
			return true;
			
		return in_array($col, $this->modifiedColumns);
	}

	/**
	 * Code to be run before updating the object in database
	 * @param PropelPDO $con
	 * @return boolean
	 */
	public function preUpdate(PropelPDO $con = null)
	{
		if ($this->alreadyInSave)
		{
			return true;
		}	
		
		
		if($this->isModified())
			$this->setUpdatedAt(time());
		
		$this->tempModifiedColumns = $this->modifiedColumns;
		return parent::preUpdate($con);
	}
	
	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->akuser !== null) {
				if (!$this->akuser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->akuser->getValidationFailures());
				}
			}


			if (($retval = hshowPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collkvotesRelatedByHshowId !== null) {
					foreach ($this->collkvotesRelatedByHshowId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collkvotesRelatedByKuserId !== null) {
					foreach ($this->collkvotesRelatedByKuserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collHshowKusers !== null) {
					foreach ($this->collHshowKusers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPuserRoles !== null) {
					foreach ($this->collPuserRoles as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collroughcutEntrys !== null) {
					foreach ($this->collroughcutEntrys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collwidgets !== null) {
					foreach ($this->collwidgets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = hshowPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getProducerId();
				break;
			case 2:
				return $this->getEpisodeId();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getSubdomain();
				break;
			case 5:
				return $this->getDescription();
				break;
			case 6:
				return $this->getStatus();
				break;
			case 7:
				return $this->getType();
				break;
			case 8:
				return $this->getMediaType();
				break;
			case 9:
				return $this->getFormatType();
				break;
			case 10:
				return $this->getLanguage();
				break;
			case 11:
				return $this->getStartDate();
				break;
			case 12:
				return $this->getEndDate();
				break;
			case 13:
				return $this->getSkin();
				break;
			case 14:
				return $this->getThumbnail();
				break;
			case 15:
				return $this->getShowEntryId();
				break;
			case 16:
				return $this->getIntroId();
				break;
			case 17:
				return $this->getViews();
				break;
			case 18:
				return $this->getVotes();
				break;
			case 19:
				return $this->getComments();
				break;
			case 20:
				return $this->getFavorites();
				break;
			case 21:
				return $this->getRank();
				break;
			case 22:
				return $this->getEntries();
				break;
			case 23:
				return $this->getContributors();
				break;
			case 24:
				return $this->getSubscribers();
				break;
			case 25:
				return $this->getNumberOfUpdates();
				break;
			case 26:
				return $this->getTags();
				break;
			case 27:
				return $this->getCustomData();
				break;
			case 28:
				return $this->getIndexedCustomData1();
				break;
			case 29:
				return $this->getIndexedCustomData2();
				break;
			case 30:
				return $this->getIndexedCustomData3();
				break;
			case 31:
				return $this->getReoccurence();
				break;
			case 32:
				return $this->getLicenseType();
				break;
			case 33:
				return $this->getLengthInMsecs();
				break;
			case 34:
				return $this->getViewPermissions();
				break;
			case 35:
				return $this->getViewPassword();
				break;
			case 36:
				return $this->getContribPermissions();
				break;
			case 37:
				return $this->getContribPassword();
				break;
			case 38:
				return $this->getEditPermissions();
				break;
			case 39:
				return $this->getEditPassword();
				break;
			case 40:
				return $this->getSalt();
				break;
			case 41:
				return $this->getCreatedAt();
				break;
			case 42:
				return $this->getUpdatedAt();
				break;
			case 43:
				return $this->getPartnerId();
				break;
			case 44:
				return $this->getDisplayInSearch();
				break;
			case 45:
				return $this->getSubpId();
				break;
			case 46:
				return $this->getPermissions();
				break;
			case 47:
				return $this->getGroupId();
				break;
			case 48:
				return $this->getPlays();
				break;
			case 49:
				return $this->getPartnerData();
				break;
			case 50:
				return $this->getIntId();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = hshowPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getProducerId(),
			$keys[2] => $this->getEpisodeId(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getSubdomain(),
			$keys[5] => $this->getDescription(),
			$keys[6] => $this->getStatus(),
			$keys[7] => $this->getType(),
			$keys[8] => $this->getMediaType(),
			$keys[9] => $this->getFormatType(),
			$keys[10] => $this->getLanguage(),
			$keys[11] => $this->getStartDate(),
			$keys[12] => $this->getEndDate(),
			$keys[13] => $this->getSkin(),
			$keys[14] => $this->getThumbnail(),
			$keys[15] => $this->getShowEntryId(),
			$keys[16] => $this->getIntroId(),
			$keys[17] => $this->getViews(),
			$keys[18] => $this->getVotes(),
			$keys[19] => $this->getComments(),
			$keys[20] => $this->getFavorites(),
			$keys[21] => $this->getRank(),
			$keys[22] => $this->getEntries(),
			$keys[23] => $this->getContributors(),
			$keys[24] => $this->getSubscribers(),
			$keys[25] => $this->getNumberOfUpdates(),
			$keys[26] => $this->getTags(),
			$keys[27] => $this->getCustomData(),
			$keys[28] => $this->getIndexedCustomData1(),
			$keys[29] => $this->getIndexedCustomData2(),
			$keys[30] => $this->getIndexedCustomData3(),
			$keys[31] => $this->getReoccurence(),
			$keys[32] => $this->getLicenseType(),
			$keys[33] => $this->getLengthInMsecs(),
			$keys[34] => $this->getViewPermissions(),
			$keys[35] => $this->getViewPassword(),
			$keys[36] => $this->getContribPermissions(),
			$keys[37] => $this->getContribPassword(),
			$keys[38] => $this->getEditPermissions(),
			$keys[39] => $this->getEditPassword(),
			$keys[40] => $this->getSalt(),
			$keys[41] => $this->getCreatedAt(),
			$keys[42] => $this->getUpdatedAt(),
			$keys[43] => $this->getPartnerId(),
			$keys[44] => $this->getDisplayInSearch(),
			$keys[45] => $this->getSubpId(),
			$keys[46] => $this->getPermissions(),
			$keys[47] => $this->getGroupId(),
			$keys[48] => $this->getPlays(),
			$keys[49] => $this->getPartnerData(),
			$keys[50] => $this->getIntId(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = hshowPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setProducerId($value);
				break;
			case 2:
				$this->setEpisodeId($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setSubdomain($value);
				break;
			case 5:
				$this->setDescription($value);
				break;
			case 6:
				$this->setStatus($value);
				break;
			case 7:
				$this->setType($value);
				break;
			case 8:
				$this->setMediaType($value);
				break;
			case 9:
				$this->setFormatType($value);
				break;
			case 10:
				$this->setLanguage($value);
				break;
			case 11:
				$this->setStartDate($value);
				break;
			case 12:
				$this->setEndDate($value);
				break;
			case 13:
				$this->setSkin($value);
				break;
			case 14:
				$this->setThumbnail($value);
				break;
			case 15:
				$this->setShowEntryId($value);
				break;
			case 16:
				$this->setIntroId($value);
				break;
			case 17:
				$this->setViews($value);
				break;
			case 18:
				$this->setVotes($value);
				break;
			case 19:
				$this->setComments($value);
				break;
			case 20:
				$this->setFavorites($value);
				break;
			case 21:
				$this->setRank($value);
				break;
			case 22:
				$this->setEntries($value);
				break;
			case 23:
				$this->setContributors($value);
				break;
			case 24:
				$this->setSubscribers($value);
				break;
			case 25:
				$this->setNumberOfUpdates($value);
				break;
			case 26:
				$this->setTags($value);
				break;
			case 27:
				$this->setCustomData($value);
				break;
			case 28:
				$this->setIndexedCustomData1($value);
				break;
			case 29:
				$this->setIndexedCustomData2($value);
				break;
			case 30:
				$this->setIndexedCustomData3($value);
				break;
			case 31:
				$this->setReoccurence($value);
				break;
			case 32:
				$this->setLicenseType($value);
				break;
			case 33:
				$this->setLengthInMsecs($value);
				break;
			case 34:
				$this->setViewPermissions($value);
				break;
			case 35:
				$this->setViewPassword($value);
				break;
			case 36:
				$this->setContribPermissions($value);
				break;
			case 37:
				$this->setContribPassword($value);
				break;
			case 38:
				$this->setEditPermissions($value);
				break;
			case 39:
				$this->setEditPassword($value);
				break;
			case 40:
				$this->setSalt($value);
				break;
			case 41:
				$this->setCreatedAt($value);
				break;
			case 42:
				$this->setUpdatedAt($value);
				break;
			case 43:
				$this->setPartnerId($value);
				break;
			case 44:
				$this->setDisplayInSearch($value);
				break;
			case 45:
				$this->setSubpId($value);
				break;
			case 46:
				$this->setPermissions($value);
				break;
			case 47:
				$this->setGroupId($value);
				break;
			case 48:
				$this->setPlays($value);
				break;
			case 49:
				$this->setPartnerData($value);
				break;
			case 50:
				$this->setIntId($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = hshowPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setProducerId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setEpisodeId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSubdomain($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDescription($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setStatus($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setType($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setMediaType($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setFormatType($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setLanguage($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setStartDate($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setEndDate($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setSkin($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setThumbnail($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setShowEntryId($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setIntroId($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setViews($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setVotes($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setComments($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setFavorites($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setRank($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setEntries($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setContributors($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setSubscribers($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setNumberOfUpdates($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setTags($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setCustomData($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setIndexedCustomData1($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setIndexedCustomData2($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setIndexedCustomData3($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setReoccurence($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setLicenseType($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setLengthInMsecs($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setViewPermissions($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setViewPassword($arr[$keys[35]]);
		if (array_key_exists($keys[36], $arr)) $this->setContribPermissions($arr[$keys[36]]);
		if (array_key_exists($keys[37], $arr)) $this->setContribPassword($arr[$keys[37]]);
		if (array_key_exists($keys[38], $arr)) $this->setEditPermissions($arr[$keys[38]]);
		if (array_key_exists($keys[39], $arr)) $this->setEditPassword($arr[$keys[39]]);
		if (array_key_exists($keys[40], $arr)) $this->setSalt($arr[$keys[40]]);
		if (array_key_exists($keys[41], $arr)) $this->setCreatedAt($arr[$keys[41]]);
		if (array_key_exists($keys[42], $arr)) $this->setUpdatedAt($arr[$keys[42]]);
		if (array_key_exists($keys[43], $arr)) $this->setPartnerId($arr[$keys[43]]);
		if (array_key_exists($keys[44], $arr)) $this->setDisplayInSearch($arr[$keys[44]]);
		if (array_key_exists($keys[45], $arr)) $this->setSubpId($arr[$keys[45]]);
		if (array_key_exists($keys[46], $arr)) $this->setPermissions($arr[$keys[46]]);
		if (array_key_exists($keys[47], $arr)) $this->setGroupId($arr[$keys[47]]);
		if (array_key_exists($keys[48], $arr)) $this->setPlays($arr[$keys[48]]);
		if (array_key_exists($keys[49], $arr)) $this->setPartnerData($arr[$keys[49]]);
		if (array_key_exists($keys[50], $arr)) $this->setIntId($arr[$keys[50]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(hshowPeer::DATABASE_NAME);

		if ($this->isColumnModified(hshowPeer::ID)) $criteria->add(hshowPeer::ID, $this->id);
		if ($this->isColumnModified(hshowPeer::PRODUCER_ID)) $criteria->add(hshowPeer::PRODUCER_ID, $this->producer_id);
		if ($this->isColumnModified(hshowPeer::EPISODE_ID)) $criteria->add(hshowPeer::EPISODE_ID, $this->episode_id);
		if ($this->isColumnModified(hshowPeer::NAME)) $criteria->add(hshowPeer::NAME, $this->name);
		if ($this->isColumnModified(hshowPeer::SUBDOMAIN)) $criteria->add(hshowPeer::SUBDOMAIN, $this->subdomain);
		if ($this->isColumnModified(hshowPeer::DESCRIPTION)) $criteria->add(hshowPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(hshowPeer::STATUS)) $criteria->add(hshowPeer::STATUS, $this->status);
		if ($this->isColumnModified(hshowPeer::TYPE)) $criteria->add(hshowPeer::TYPE, $this->type);
		if ($this->isColumnModified(hshowPeer::MEDIA_TYPE)) $criteria->add(hshowPeer::MEDIA_TYPE, $this->media_type);
		if ($this->isColumnModified(hshowPeer::FORMAT_TYPE)) $criteria->add(hshowPeer::FORMAT_TYPE, $this->format_type);
		if ($this->isColumnModified(hshowPeer::LANGUAGE)) $criteria->add(hshowPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(hshowPeer::START_DATE)) $criteria->add(hshowPeer::START_DATE, $this->start_date);
		if ($this->isColumnModified(hshowPeer::END_DATE)) $criteria->add(hshowPeer::END_DATE, $this->end_date);
		if ($this->isColumnModified(hshowPeer::SKIN)) $criteria->add(hshowPeer::SKIN, $this->skin);
		if ($this->isColumnModified(hshowPeer::THUMBNAIL)) $criteria->add(hshowPeer::THUMBNAIL, $this->thumbnail);
		if ($this->isColumnModified(hshowPeer::SHOW_ENTRY_ID)) $criteria->add(hshowPeer::SHOW_ENTRY_ID, $this->show_entry_id);
		if ($this->isColumnModified(hshowPeer::INTRO_ID)) $criteria->add(hshowPeer::INTRO_ID, $this->intro_id);
		if ($this->isColumnModified(hshowPeer::VIEWS)) $criteria->add(hshowPeer::VIEWS, $this->views);
		if ($this->isColumnModified(hshowPeer::VOTES)) $criteria->add(hshowPeer::VOTES, $this->votes);
		if ($this->isColumnModified(hshowPeer::COMMENTS)) $criteria->add(hshowPeer::COMMENTS, $this->comments);
		if ($this->isColumnModified(hshowPeer::FAVORITES)) $criteria->add(hshowPeer::FAVORITES, $this->favorites);
		if ($this->isColumnModified(hshowPeer::RANK)) $criteria->add(hshowPeer::RANK, $this->rank);
		if ($this->isColumnModified(hshowPeer::ENTRIES)) $criteria->add(hshowPeer::ENTRIES, $this->entries);
		if ($this->isColumnModified(hshowPeer::CONTRIBUTORS)) $criteria->add(hshowPeer::CONTRIBUTORS, $this->contributors);
		if ($this->isColumnModified(hshowPeer::SUBSCRIBERS)) $criteria->add(hshowPeer::SUBSCRIBERS, $this->subscribers);
		if ($this->isColumnModified(hshowPeer::NUMBER_OF_UPDATES)) $criteria->add(hshowPeer::NUMBER_OF_UPDATES, $this->number_of_updates);
		if ($this->isColumnModified(hshowPeer::TAGS)) $criteria->add(hshowPeer::TAGS, $this->tags);
		if ($this->isColumnModified(hshowPeer::CUSTOM_DATA)) $criteria->add(hshowPeer::CUSTOM_DATA, $this->custom_data);
		if ($this->isColumnModified(hshowPeer::INDEXED_CUSTOM_DATA_1)) $criteria->add(hshowPeer::INDEXED_CUSTOM_DATA_1, $this->indexed_custom_data_1);
		if ($this->isColumnModified(hshowPeer::INDEXED_CUSTOM_DATA_2)) $criteria->add(hshowPeer::INDEXED_CUSTOM_DATA_2, $this->indexed_custom_data_2);
		if ($this->isColumnModified(hshowPeer::INDEXED_CUSTOM_DATA_3)) $criteria->add(hshowPeer::INDEXED_CUSTOM_DATA_3, $this->indexed_custom_data_3);
		if ($this->isColumnModified(hshowPeer::REOCCURENCE)) $criteria->add(hshowPeer::REOCCURENCE, $this->reoccurence);
		if ($this->isColumnModified(hshowPeer::LICENSE_TYPE)) $criteria->add(hshowPeer::LICENSE_TYPE, $this->license_type);
		if ($this->isColumnModified(hshowPeer::LENGTH_IN_MSECS)) $criteria->add(hshowPeer::LENGTH_IN_MSECS, $this->length_in_msecs);
		if ($this->isColumnModified(hshowPeer::VIEW_PERMISSIONS)) $criteria->add(hshowPeer::VIEW_PERMISSIONS, $this->view_permissions);
		if ($this->isColumnModified(hshowPeer::VIEW_PASSWORD)) $criteria->add(hshowPeer::VIEW_PASSWORD, $this->view_password);
		if ($this->isColumnModified(hshowPeer::CONTRIB_PERMISSIONS)) $criteria->add(hshowPeer::CONTRIB_PERMISSIONS, $this->contrib_permissions);
		if ($this->isColumnModified(hshowPeer::CONTRIB_PASSWORD)) $criteria->add(hshowPeer::CONTRIB_PASSWORD, $this->contrib_password);
		if ($this->isColumnModified(hshowPeer::EDIT_PERMISSIONS)) $criteria->add(hshowPeer::EDIT_PERMISSIONS, $this->edit_permissions);
		if ($this->isColumnModified(hshowPeer::EDIT_PASSWORD)) $criteria->add(hshowPeer::EDIT_PASSWORD, $this->edit_password);
		if ($this->isColumnModified(hshowPeer::SALT)) $criteria->add(hshowPeer::SALT, $this->salt);
		if ($this->isColumnModified(hshowPeer::CREATED_AT)) $criteria->add(hshowPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(hshowPeer::UPDATED_AT)) $criteria->add(hshowPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(hshowPeer::PARTNER_ID)) $criteria->add(hshowPeer::PARTNER_ID, $this->partner_id);
		if ($this->isColumnModified(hshowPeer::DISPLAY_IN_SEARCH)) $criteria->add(hshowPeer::DISPLAY_IN_SEARCH, $this->display_in_search);
		if ($this->isColumnModified(hshowPeer::SUBP_ID)) $criteria->add(hshowPeer::SUBP_ID, $this->subp_id);
		if ($this->isColumnModified(hshowPeer::PERMISSIONS)) $criteria->add(hshowPeer::PERMISSIONS, $this->permissions);
		if ($this->isColumnModified(hshowPeer::GROUP_ID)) $criteria->add(hshowPeer::GROUP_ID, $this->group_id);
		if ($this->isColumnModified(hshowPeer::PLAYS)) $criteria->add(hshowPeer::PLAYS, $this->plays);
		if ($this->isColumnModified(hshowPeer::PARTNER_DATA)) $criteria->add(hshowPeer::PARTNER_DATA, $this->partner_data);
		if ($this->isColumnModified(hshowPeer::INT_ID)) $criteria->add(hshowPeer::INT_ID, $this->int_id);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(hshowPeer::DATABASE_NAME);

		$criteria->add(hshowPeer::ID, $this->id);
		
		if($this->alreadyInSave)
		{
			if ($this->isColumnModified(hshowPeer::CUSTOM_DATA))
			{
				if (!is_null($this->custom_data_md5))
					$criteria->add(hshowPeer::CUSTOM_DATA, "MD5(cast(" . hshowPeer::CUSTOM_DATA . " as char character set latin1)) = '$this->custom_data_md5'", Criteria::CUSTOM);
					//casting to latin char set to avoid mysql and php md5 difference
				else 
					$criteria->add(hshowPeer::CUSTOM_DATA, NULL, Criteria::ISNULL);
			}
			
			if (count($this->modifiedColumns) == 2 && $this->isColumnModified(hshowPeer::UPDATED_AT))
			{
				$theModifiedColumn = null;
				foreach($this->modifiedColumns as $modifiedColumn)
					if($modifiedColumn != hshowPeer::UPDATED_AT)
						$theModifiedColumn = $modifiedColumn;
						
				$atomicColumns = hshowPeer::getAtomicColumns();
				if(in_array($theModifiedColumn, $atomicColumns))
					$criteria->add($theModifiedColumn, $this->getByName($theModifiedColumn, BasePeer::TYPE_COLNAME), Criteria::NOT_EQUAL);
			}
		}		

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     string
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      string $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of hshow (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setId($this->id);

		$copyObj->setProducerId($this->producer_id);

		$copyObj->setEpisodeId($this->episode_id);

		$copyObj->setName($this->name);

		$copyObj->setSubdomain($this->subdomain);

		$copyObj->setDescription($this->description);

		$copyObj->setStatus($this->status);

		$copyObj->setType($this->type);

		$copyObj->setMediaType($this->media_type);

		$copyObj->setFormatType($this->format_type);

		$copyObj->setLanguage($this->language);

		$copyObj->setStartDate($this->start_date);

		$copyObj->setEndDate($this->end_date);

		$copyObj->setSkin($this->skin);

		$copyObj->setThumbnail($this->thumbnail);

		$copyObj->setShowEntryId($this->show_entry_id);

		$copyObj->setIntroId($this->intro_id);

		$copyObj->setViews($this->views);

		$copyObj->setVotes($this->votes);

		$copyObj->setComments($this->comments);

		$copyObj->setFavorites($this->favorites);

		$copyObj->setRank($this->rank);

		$copyObj->setEntries($this->entries);

		$copyObj->setContributors($this->contributors);

		$copyObj->setSubscribers($this->subscribers);

		$copyObj->setNumberOfUpdates($this->number_of_updates);

		$copyObj->setTags($this->tags);

		$copyObj->setCustomData($this->custom_data);

		$copyObj->setIndexedCustomData1($this->indexed_custom_data_1);

		$copyObj->setIndexedCustomData2($this->indexed_custom_data_2);

		$copyObj->setIndexedCustomData3($this->indexed_custom_data_3);

		$copyObj->setReoccurence($this->reoccurence);

		$copyObj->setLicenseType($this->license_type);

		$copyObj->setLengthInMsecs($this->length_in_msecs);

		$copyObj->setViewPermissions($this->view_permissions);

		$copyObj->setViewPassword($this->view_password);

		$copyObj->setContribPermissions($this->contrib_permissions);

		$copyObj->setContribPassword($this->contrib_password);

		$copyObj->setEditPermissions($this->edit_permissions);

		$copyObj->setEditPassword($this->edit_password);

		$copyObj->setSalt($this->salt);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setPartnerId($this->partner_id);

		$copyObj->setDisplayInSearch($this->display_in_search);

		$copyObj->setSubpId($this->subp_id);

		$copyObj->setPermissions($this->permissions);

		$copyObj->setGroupId($this->group_id);

		$copyObj->setPlays($this->plays);

		$copyObj->setPartnerData($this->partner_data);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getkvotesRelatedByHshowId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addkvoteRelatedByHshowId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getkvotesRelatedByKuserId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addkvoteRelatedByKuserId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getHshowKusers() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addHshowKuser($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPuserRoles() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPuserRole($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getroughcutEntrys() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addroughcutEntry($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getwidgets() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addwidget($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setIntId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     hshow Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		$copyObj->setCopiedFrom($this);
		return $copyObj;
	}
	
	/**
	 * Stores the source object that this object copied from 
	 *
	 * @var     hshow Clone of current object.
	 */
	protected $copiedFrom = null;
	
	/**
	 * Stores the source object that this object copied from 
	 *
	 * @param      hshow $copiedFrom Clone of current object.
	 */
	public function setCopiedFrom(hshow $copiedFrom)
	{
		$this->copiedFrom = $copiedFrom;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     hshowPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new hshowPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a kuser object.
	 *
	 * @param      kuser $v
	 * @return     hshow The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setkuser(kuser $v = null)
	{
		if ($v === null) {
			$this->setProducerId(NULL);
		} else {
			$this->setProducerId($v->getId());
		}

		$this->akuser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the kuser object, it will not be re-added.
		if ($v !== null) {
			$v->addhshow($this);
		}

		return $this;
	}


	/**
	 * Get the associated kuser object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     kuser The associated kuser object.
	 * @throws     PropelException
	 */
	public function getkuser(PropelPDO $con = null)
	{
		if ($this->akuser === null && ($this->producer_id !== null)) {
			$this->akuser = kuserPeer::retrieveByPk($this->producer_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->akuser->addhshows($this);
			 */
		}
		return $this->akuser;
	}

	/**
	 * Clears out the collkvotesRelatedByHshowId collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addkvotesRelatedByHshowId()
	 */
	public function clearkvotesRelatedByHshowId()
	{
		$this->collkvotesRelatedByHshowId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collkvotesRelatedByHshowId collection (array).
	 *
	 * By default this just sets the collkvotesRelatedByHshowId collection to an empty array (like clearcollkvotesRelatedByHshowId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initkvotesRelatedByHshowId()
	{
		$this->collkvotesRelatedByHshowId = array();
	}

	/**
	 * Gets an array of kvote objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this hshow has previously been saved, it will retrieve
	 * related kvotesRelatedByHshowId from storage. If this hshow is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array kvote[]
	 * @throws     PropelException
	 */
	public function getkvotesRelatedByHshowId($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collkvotesRelatedByHshowId === null) {
			if ($this->isNew()) {
			   $this->collkvotesRelatedByHshowId = array();
			} else {

				$criteria->add(kvotePeer::HSHOW_ID, $this->id);

				kvotePeer::addSelectColumns($criteria);
				$this->collkvotesRelatedByHshowId = kvotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(kvotePeer::HSHOW_ID, $this->id);

				kvotePeer::addSelectColumns($criteria);
				if (!isset($this->lastkvoteRelatedByHshowIdCriteria) || !$this->lastkvoteRelatedByHshowIdCriteria->equals($criteria)) {
					$this->collkvotesRelatedByHshowId = kvotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastkvoteRelatedByHshowIdCriteria = $criteria;
		return $this->collkvotesRelatedByHshowId;
	}

	/**
	 * Returns the number of related kvote objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related kvote objects.
	 * @throws     PropelException
	 */
	public function countkvotesRelatedByHshowId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collkvotesRelatedByHshowId === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(kvotePeer::HSHOW_ID, $this->id);

				$count = kvotePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(kvotePeer::HSHOW_ID, $this->id);

				if (!isset($this->lastkvoteRelatedByHshowIdCriteria) || !$this->lastkvoteRelatedByHshowIdCriteria->equals($criteria)) {
					$count = kvotePeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collkvotesRelatedByHshowId);
				}
			} else {
				$count = count($this->collkvotesRelatedByHshowId);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a kvote object to this object
	 * through the kvote foreign key attribute.
	 *
	 * @param      kvote $l kvote
	 * @return     void
	 * @throws     PropelException
	 */
	public function addkvoteRelatedByHshowId(kvote $l)
	{
		if ($this->collkvotesRelatedByHshowId === null) {
			$this->initkvotesRelatedByHshowId();
		}
		if (!in_array($l, $this->collkvotesRelatedByHshowId, true)) { // only add it if the **same** object is not already associated
			array_push($this->collkvotesRelatedByHshowId, $l);
			$l->sethshowRelatedByHshowId($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related kvotesRelatedByHshowId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getkvotesRelatedByHshowIdJoinentry($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collkvotesRelatedByHshowId === null) {
			if ($this->isNew()) {
				$this->collkvotesRelatedByHshowId = array();
			} else {

				$criteria->add(kvotePeer::HSHOW_ID, $this->id);

				$this->collkvotesRelatedByHshowId = kvotePeer::doSelectJoinentry($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(kvotePeer::HSHOW_ID, $this->id);

			if (!isset($this->lastkvoteRelatedByHshowIdCriteria) || !$this->lastkvoteRelatedByHshowIdCriteria->equals($criteria)) {
				$this->collkvotesRelatedByHshowId = kvotePeer::doSelectJoinentry($criteria, $con, $join_behavior);
			}
		}
		$this->lastkvoteRelatedByHshowIdCriteria = $criteria;

		return $this->collkvotesRelatedByHshowId;
	}

	/**
	 * Clears out the collkvotesRelatedByKuserId collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addkvotesRelatedByKuserId()
	 */
	public function clearkvotesRelatedByKuserId()
	{
		$this->collkvotesRelatedByKuserId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collkvotesRelatedByKuserId collection (array).
	 *
	 * By default this just sets the collkvotesRelatedByKuserId collection to an empty array (like clearcollkvotesRelatedByKuserId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initkvotesRelatedByKuserId()
	{
		$this->collkvotesRelatedByKuserId = array();
	}

	/**
	 * Gets an array of kvote objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this hshow has previously been saved, it will retrieve
	 * related kvotesRelatedByKuserId from storage. If this hshow is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array kvote[]
	 * @throws     PropelException
	 */
	public function getkvotesRelatedByKuserId($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collkvotesRelatedByKuserId === null) {
			if ($this->isNew()) {
			   $this->collkvotesRelatedByKuserId = array();
			} else {

				$criteria->add(kvotePeer::KUSER_ID, $this->id);

				kvotePeer::addSelectColumns($criteria);
				$this->collkvotesRelatedByKuserId = kvotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(kvotePeer::KUSER_ID, $this->id);

				kvotePeer::addSelectColumns($criteria);
				if (!isset($this->lastkvoteRelatedByKuserIdCriteria) || !$this->lastkvoteRelatedByKuserIdCriteria->equals($criteria)) {
					$this->collkvotesRelatedByKuserId = kvotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastkvoteRelatedByKuserIdCriteria = $criteria;
		return $this->collkvotesRelatedByKuserId;
	}

	/**
	 * Returns the number of related kvote objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related kvote objects.
	 * @throws     PropelException
	 */
	public function countkvotesRelatedByKuserId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collkvotesRelatedByKuserId === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(kvotePeer::KUSER_ID, $this->id);

				$count = kvotePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(kvotePeer::KUSER_ID, $this->id);

				if (!isset($this->lastkvoteRelatedByKuserIdCriteria) || !$this->lastkvoteRelatedByKuserIdCriteria->equals($criteria)) {
					$count = kvotePeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collkvotesRelatedByKuserId);
				}
			} else {
				$count = count($this->collkvotesRelatedByKuserId);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a kvote object to this object
	 * through the kvote foreign key attribute.
	 *
	 * @param      kvote $l kvote
	 * @return     void
	 * @throws     PropelException
	 */
	public function addkvoteRelatedByKuserId(kvote $l)
	{
		if ($this->collkvotesRelatedByKuserId === null) {
			$this->initkvotesRelatedByKuserId();
		}
		if (!in_array($l, $this->collkvotesRelatedByKuserId, true)) { // only add it if the **same** object is not already associated
			array_push($this->collkvotesRelatedByKuserId, $l);
			$l->sethshowRelatedByKuserId($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related kvotesRelatedByKuserId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getkvotesRelatedByKuserIdJoinentry($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collkvotesRelatedByKuserId === null) {
			if ($this->isNew()) {
				$this->collkvotesRelatedByKuserId = array();
			} else {

				$criteria->add(kvotePeer::KUSER_ID, $this->id);

				$this->collkvotesRelatedByKuserId = kvotePeer::doSelectJoinentry($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(kvotePeer::KUSER_ID, $this->id);

			if (!isset($this->lastkvoteRelatedByKuserIdCriteria) || !$this->lastkvoteRelatedByKuserIdCriteria->equals($criteria)) {
				$this->collkvotesRelatedByKuserId = kvotePeer::doSelectJoinentry($criteria, $con, $join_behavior);
			}
		}
		$this->lastkvoteRelatedByKuserIdCriteria = $criteria;

		return $this->collkvotesRelatedByKuserId;
	}

	/**
	 * Clears out the collHshowKusers collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addHshowKusers()
	 */
	public function clearHshowKusers()
	{
		$this->collHshowKusers = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collHshowKusers collection (array).
	 *
	 * By default this just sets the collHshowKusers collection to an empty array (like clearcollHshowKusers());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initHshowKusers()
	{
		$this->collHshowKusers = array();
	}

	/**
	 * Gets an array of HshowKuser objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this hshow has previously been saved, it will retrieve
	 * related HshowKusers from storage. If this hshow is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array HshowKuser[]
	 * @throws     PropelException
	 */
	public function getHshowKusers($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHshowKusers === null) {
			if ($this->isNew()) {
			   $this->collHshowKusers = array();
			} else {

				$criteria->add(HshowKuserPeer::HSHOW_ID, $this->id);

				HshowKuserPeer::addSelectColumns($criteria);
				$this->collHshowKusers = HshowKuserPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(HshowKuserPeer::HSHOW_ID, $this->id);

				HshowKuserPeer::addSelectColumns($criteria);
				if (!isset($this->lastHshowKuserCriteria) || !$this->lastHshowKuserCriteria->equals($criteria)) {
					$this->collHshowKusers = HshowKuserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHshowKuserCriteria = $criteria;
		return $this->collHshowKusers;
	}

	/**
	 * Returns the number of related HshowKuser objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related HshowKuser objects.
	 * @throws     PropelException
	 */
	public function countHshowKusers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collHshowKusers === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(HshowKuserPeer::HSHOW_ID, $this->id);

				$count = HshowKuserPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(HshowKuserPeer::HSHOW_ID, $this->id);

				if (!isset($this->lastHshowKuserCriteria) || !$this->lastHshowKuserCriteria->equals($criteria)) {
					$count = HshowKuserPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collHshowKusers);
				}
			} else {
				$count = count($this->collHshowKusers);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a HshowKuser object to this object
	 * through the HshowKuser foreign key attribute.
	 *
	 * @param      HshowKuser $l HshowKuser
	 * @return     void
	 * @throws     PropelException
	 */
	public function addHshowKuser(HshowKuser $l)
	{
		if ($this->collHshowKusers === null) {
			$this->initHshowKusers();
		}
		if (!in_array($l, $this->collHshowKusers, true)) { // only add it if the **same** object is not already associated
			array_push($this->collHshowKusers, $l);
			$l->sethshow($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related HshowKusers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getHshowKusersJoinkuser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHshowKusers === null) {
			if ($this->isNew()) {
				$this->collHshowKusers = array();
			} else {

				$criteria->add(HshowKuserPeer::HSHOW_ID, $this->id);

				$this->collHshowKusers = HshowKuserPeer::doSelectJoinkuser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(HshowKuserPeer::HSHOW_ID, $this->id);

			if (!isset($this->lastHshowKuserCriteria) || !$this->lastHshowKuserCriteria->equals($criteria)) {
				$this->collHshowKusers = HshowKuserPeer::doSelectJoinkuser($criteria, $con, $join_behavior);
			}
		}
		$this->lastHshowKuserCriteria = $criteria;

		return $this->collHshowKusers;
	}

	/**
	 * Clears out the collPuserRoles collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPuserRoles()
	 */
	public function clearPuserRoles()
	{
		$this->collPuserRoles = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPuserRoles collection (array).
	 *
	 * By default this just sets the collPuserRoles collection to an empty array (like clearcollPuserRoles());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPuserRoles()
	{
		$this->collPuserRoles = array();
	}

	/**
	 * Gets an array of PuserRole objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this hshow has previously been saved, it will retrieve
	 * related PuserRoles from storage. If this hshow is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PuserRole[]
	 * @throws     PropelException
	 */
	public function getPuserRoles($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPuserRoles === null) {
			if ($this->isNew()) {
			   $this->collPuserRoles = array();
			} else {

				$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

				PuserRolePeer::addSelectColumns($criteria);
				$this->collPuserRoles = PuserRolePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

				PuserRolePeer::addSelectColumns($criteria);
				if (!isset($this->lastPuserRoleCriteria) || !$this->lastPuserRoleCriteria->equals($criteria)) {
					$this->collPuserRoles = PuserRolePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPuserRoleCriteria = $criteria;
		return $this->collPuserRoles;
	}

	/**
	 * Returns the number of related PuserRole objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PuserRole objects.
	 * @throws     PropelException
	 */
	public function countPuserRoles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPuserRoles === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

				$count = PuserRolePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

				if (!isset($this->lastPuserRoleCriteria) || !$this->lastPuserRoleCriteria->equals($criteria)) {
					$count = PuserRolePeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPuserRoles);
				}
			} else {
				$count = count($this->collPuserRoles);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PuserRole object to this object
	 * through the PuserRole foreign key attribute.
	 *
	 * @param      PuserRole $l PuserRole
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPuserRole(PuserRole $l)
	{
		if ($this->collPuserRoles === null) {
			$this->initPuserRoles();
		}
		if (!in_array($l, $this->collPuserRoles, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPuserRoles, $l);
			$l->sethshow($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related PuserRoles from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getPuserRolesJoinPuserKuserRelatedByPartnerId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPuserRoles === null) {
			if ($this->isNew()) {
				$this->collPuserRoles = array();
			} else {

				$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

				$this->collPuserRoles = PuserRolePeer::doSelectJoinPuserKuserRelatedByPartnerId($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

			if (!isset($this->lastPuserRoleCriteria) || !$this->lastPuserRoleCriteria->equals($criteria)) {
				$this->collPuserRoles = PuserRolePeer::doSelectJoinPuserKuserRelatedByPartnerId($criteria, $con, $join_behavior);
			}
		}
		$this->lastPuserRoleCriteria = $criteria;

		return $this->collPuserRoles;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related PuserRoles from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getPuserRolesJoinPuserKuserRelatedByPuserId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPuserRoles === null) {
			if ($this->isNew()) {
				$this->collPuserRoles = array();
			} else {

				$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

				$this->collPuserRoles = PuserRolePeer::doSelectJoinPuserKuserRelatedByPuserId($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PuserRolePeer::HSHOW_ID, $this->id);

			if (!isset($this->lastPuserRoleCriteria) || !$this->lastPuserRoleCriteria->equals($criteria)) {
				$this->collPuserRoles = PuserRolePeer::doSelectJoinPuserKuserRelatedByPuserId($criteria, $con, $join_behavior);
			}
		}
		$this->lastPuserRoleCriteria = $criteria;

		return $this->collPuserRoles;
	}

	/**
	 * Clears out the collroughcutEntrys collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addroughcutEntrys()
	 */
	public function clearroughcutEntrys()
	{
		$this->collroughcutEntrys = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collroughcutEntrys collection (array).
	 *
	 * By default this just sets the collroughcutEntrys collection to an empty array (like clearcollroughcutEntrys());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initroughcutEntrys()
	{
		$this->collroughcutEntrys = array();
	}

	/**
	 * Gets an array of roughcutEntry objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this hshow has previously been saved, it will retrieve
	 * related roughcutEntrys from storage. If this hshow is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array roughcutEntry[]
	 * @throws     PropelException
	 */
	public function getroughcutEntrys($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collroughcutEntrys === null) {
			if ($this->isNew()) {
			   $this->collroughcutEntrys = array();
			} else {

				$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

				roughcutEntryPeer::addSelectColumns($criteria);
				$this->collroughcutEntrys = roughcutEntryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

				roughcutEntryPeer::addSelectColumns($criteria);
				if (!isset($this->lastroughcutEntryCriteria) || !$this->lastroughcutEntryCriteria->equals($criteria)) {
					$this->collroughcutEntrys = roughcutEntryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastroughcutEntryCriteria = $criteria;
		return $this->collroughcutEntrys;
	}

	/**
	 * Returns the number of related roughcutEntry objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related roughcutEntry objects.
	 * @throws     PropelException
	 */
	public function countroughcutEntrys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collroughcutEntrys === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

				$count = roughcutEntryPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

				if (!isset($this->lastroughcutEntryCriteria) || !$this->lastroughcutEntryCriteria->equals($criteria)) {
					$count = roughcutEntryPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collroughcutEntrys);
				}
			} else {
				$count = count($this->collroughcutEntrys);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a roughcutEntry object to this object
	 * through the roughcutEntry foreign key attribute.
	 *
	 * @param      roughcutEntry $l roughcutEntry
	 * @return     void
	 * @throws     PropelException
	 */
	public function addroughcutEntry(roughcutEntry $l)
	{
		if ($this->collroughcutEntrys === null) {
			$this->initroughcutEntrys();
		}
		if (!in_array($l, $this->collroughcutEntrys, true)) { // only add it if the **same** object is not already associated
			array_push($this->collroughcutEntrys, $l);
			$l->sethshow($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related roughcutEntrys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getroughcutEntrysJoinentryRelatedByRoughcutId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collroughcutEntrys === null) {
			if ($this->isNew()) {
				$this->collroughcutEntrys = array();
			} else {

				$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

				$this->collroughcutEntrys = roughcutEntryPeer::doSelectJoinentryRelatedByRoughcutId($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

			if (!isset($this->lastroughcutEntryCriteria) || !$this->lastroughcutEntryCriteria->equals($criteria)) {
				$this->collroughcutEntrys = roughcutEntryPeer::doSelectJoinentryRelatedByRoughcutId($criteria, $con, $join_behavior);
			}
		}
		$this->lastroughcutEntryCriteria = $criteria;

		return $this->collroughcutEntrys;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related roughcutEntrys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getroughcutEntrysJoinentryRelatedByEntryId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collroughcutEntrys === null) {
			if ($this->isNew()) {
				$this->collroughcutEntrys = array();
			} else {

				$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

				$this->collroughcutEntrys = roughcutEntryPeer::doSelectJoinentryRelatedByEntryId($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(roughcutEntryPeer::ROUGHCUT_HSHOW_ID, $this->id);

			if (!isset($this->lastroughcutEntryCriteria) || !$this->lastroughcutEntryCriteria->equals($criteria)) {
				$this->collroughcutEntrys = roughcutEntryPeer::doSelectJoinentryRelatedByEntryId($criteria, $con, $join_behavior);
			}
		}
		$this->lastroughcutEntryCriteria = $criteria;

		return $this->collroughcutEntrys;
	}

	/**
	 * Clears out the collwidgets collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addwidgets()
	 */
	public function clearwidgets()
	{
		$this->collwidgets = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collwidgets collection (array).
	 *
	 * By default this just sets the collwidgets collection to an empty array (like clearcollwidgets());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initwidgets()
	{
		$this->collwidgets = array();
	}

	/**
	 * Gets an array of widget objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this hshow has previously been saved, it will retrieve
	 * related widgets from storage. If this hshow is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array widget[]
	 * @throws     PropelException
	 */
	public function getwidgets($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collwidgets === null) {
			if ($this->isNew()) {
			   $this->collwidgets = array();
			} else {

				$criteria->add(widgetPeer::HSHOW_ID, $this->id);

				widgetPeer::addSelectColumns($criteria);
				$this->collwidgets = widgetPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(widgetPeer::HSHOW_ID, $this->id);

				widgetPeer::addSelectColumns($criteria);
				if (!isset($this->lastwidgetCriteria) || !$this->lastwidgetCriteria->equals($criteria)) {
					$this->collwidgets = widgetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastwidgetCriteria = $criteria;
		return $this->collwidgets;
	}

	/**
	 * Returns the number of related widget objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related widget objects.
	 * @throws     PropelException
	 */
	public function countwidgets(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collwidgets === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(widgetPeer::HSHOW_ID, $this->id);

				$count = widgetPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(widgetPeer::HSHOW_ID, $this->id);

				if (!isset($this->lastwidgetCriteria) || !$this->lastwidgetCriteria->equals($criteria)) {
					$count = widgetPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collwidgets);
				}
			} else {
				$count = count($this->collwidgets);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a widget object to this object
	 * through the widget foreign key attribute.
	 *
	 * @param      widget $l widget
	 * @return     void
	 * @throws     PropelException
	 */
	public function addwidget(widget $l)
	{
		if ($this->collwidgets === null) {
			$this->initwidgets();
		}
		if (!in_array($l, $this->collwidgets, true)) { // only add it if the **same** object is not already associated
			array_push($this->collwidgets, $l);
			$l->sethshow($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related widgets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getwidgetsJoinentry($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collwidgets === null) {
			if ($this->isNew()) {
				$this->collwidgets = array();
			} else {

				$criteria->add(widgetPeer::HSHOW_ID, $this->id);

				$this->collwidgets = widgetPeer::doSelectJoinentry($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(widgetPeer::HSHOW_ID, $this->id);

			if (!isset($this->lastwidgetCriteria) || !$this->lastwidgetCriteria->equals($criteria)) {
				$this->collwidgets = widgetPeer::doSelectJoinentry($criteria, $con, $join_behavior);
			}
		}
		$this->lastwidgetCriteria = $criteria;

		return $this->collwidgets;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this hshow is new, it will return
	 * an empty collection; or if this hshow has previously
	 * been saved, it will retrieve related widgets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in hshow.
	 */
	public function getwidgetsJoinuiConf($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(hshowPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collwidgets === null) {
			if ($this->isNew()) {
				$this->collwidgets = array();
			} else {

				$criteria->add(widgetPeer::HSHOW_ID, $this->id);

				$this->collwidgets = widgetPeer::doSelectJoinuiConf($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(widgetPeer::HSHOW_ID, $this->id);

			if (!isset($this->lastwidgetCriteria) || !$this->lastwidgetCriteria->equals($criteria)) {
				$this->collwidgets = widgetPeer::doSelectJoinuiConf($criteria, $con, $join_behavior);
			}
		}
		$this->lastwidgetCriteria = $criteria;

		return $this->collwidgets;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collkvotesRelatedByHshowId) {
				foreach ((array) $this->collkvotesRelatedByHshowId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collkvotesRelatedByKuserId) {
				foreach ((array) $this->collkvotesRelatedByKuserId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collHshowKusers) {
				foreach ((array) $this->collHshowKusers as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPuserRoles) {
				foreach ((array) $this->collPuserRoles as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collroughcutEntrys) {
				foreach ((array) $this->collroughcutEntrys as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collwidgets) {
				foreach ((array) $this->collwidgets as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collkvotesRelatedByHshowId = null;
		$this->collkvotesRelatedByKuserId = null;
		$this->collHshowKusers = null;
		$this->collPuserRoles = null;
		$this->collroughcutEntrys = null;
		$this->collwidgets = null;
			$this->akuser = null;
	}

	/* ---------------------- CustomData functions ------------------------- */

	/**
	 * @var myCustomData
	 */
	protected $m_custom_data = null;
	
	/**
	 * The md5 value for the custom_data field.
	 * @var        string
	 */
	protected $custom_data_md5;

	/**
	 * Store custom data old values before the changes
	 * @var        array
	 */
	protected $oldCustomDataValues = array();
	
	/**
	 * @return array
	 */
	public function getCustomDataOldValues()
	{
		return $this->oldCustomDataValues;
	}
	
	/**
	 * @param string $name
	 * @param string $value
	 * @param string $namespace
	 * @return string
	 */
	public function putInCustomData ( $name , $value , $namespace = null )
	{
		$customData = $this->getCustomDataObj( );
		
		$currentNamespace = '';
		if($namespace)
			$currentNamespace = $namespace;
			
		if(!isset($this->oldCustomDataValues[$currentNamespace]))
			$this->oldCustomDataValues[$currentNamespace] = array();
		if(!isset($this->oldCustomDataValues[$currentNamespace][$name]))
			$this->oldCustomDataValues[$currentNamespace][$name] = $customData->get($name, $namespace);
		
		$customData->put ( $name , $value , $namespace );
	}

	/**
	 * @param string $name
	 * @param string $namespace
	 * @param string $defaultValue
	 * @return string
	 */
	public function getFromCustomData ( $name , $namespace = null , $defaultValue = null )
	{
		$customData = $this->getCustomDataObj( );
		$res = $customData->get ( $name , $namespace );
		if ( $res === null ) return $defaultValue;
		return $res;
	}

	/**
	 * @param string $name
	 * @param string $namespace
	 */
	public function removeFromCustomData ( $name , $namespace = null)
	{
		$customData = $this->getCustomDataObj();
		
		$currentNamespace = '';
		if($namespace)
			$currentNamespace = $namespace;
			
		if(!isset($this->oldCustomDataValues[$currentNamespace]))
			$this->oldCustomDataValues[$currentNamespace] = array();
		if(!isset($this->oldCustomDataValues[$currentNamespace][$name]))
			$this->oldCustomDataValues[$currentNamespace][$name] = $customData->get($name, $namespace);
		
		return $customData->remove ( $name , $namespace );
	}

	/**
	 * @param string $name
	 * @param int $delta
	 * @param string $namespace
	 * @return string
	 */
	public function incInCustomData ( $name , $delta = 1, $namespace = null)
	{
		$customData = $this->getCustomDataObj( );
		
		$currentNamespace = '';
		if($namespace)
			$currentNamespace = $namespace;
			
		if(!isset($this->oldCustomDataValues[$currentNamespace]))
			$this->oldCustomDataValues[$currentNamespace] = array();
		if(!isset($this->oldCustomDataValues[$currentNamespace][$name]))
			$this->oldCustomDataValues[$currentNamespace][$name] = $customData->get($name, $namespace);
		
		return $customData->inc ( $name , $delta , $namespace  );
	}

	/**
	 * @param string $name
	 * @param int $delta
	 * @param string $namespace
	 * @return string
	 */
	public function decInCustomData ( $name , $delta = 1, $namespace = null)
	{
		$customData = $this->getCustomDataObj(  );
		return $customData->dec ( $name , $delta , $namespace );
	}

	/**
	 * @return myCustomData
	 */
	public function getCustomDataObj( )
	{
		if ( ! $this->m_custom_data )
		{
			$this->m_custom_data = myCustomData::fromString ( $this->getCustomData() );
		}
		return $this->m_custom_data;
	}
	
	/**
	 * Must be called before saving the object
	 */
	public function setCustomDataObj()
	{
		if ( $this->m_custom_data != null )
		{
			$this->custom_data_md5 = is_null($this->custom_data) ? null : md5($this->custom_data);
			$this->setCustomData( $this->m_custom_data->toString() );
		}
	}
	
	/* ---------------------- CustomData functions ------------------------- */
	
} // Basehshow
