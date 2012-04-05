<?php
/**
 * [平成23年6月30日現在法令等]
 *
 * 所得税の税率は、分離課税に対するものなどを除くと、5％から40％の6段階に区分されています。
 * 課税される総所得金額(千円未満の端数金額を切り捨てた後の金額です。)に対する所得税の金額は、次の速算表を使用すると簡単に求められます。
 *
 * +---------------------------+-----+-------------+
 * | 課税される所得金額          | 税率 | 控除額      |
 * +---------------------------+-----+-------------+
 * | 195万円以下                |  5% |         0円 |
 * +---------------------------+-----+-------------+
 * | 195万円を超え 330万円以下   | 10% |    97,500円 |
 * +---------------------------+-----+-------------+
 * | 330万円を超え 695万円以下   | 20% |   427,500円 |
 * +---------------------------+-----+-------------+
 * | 695万円を超え 900万円以下   | 23% |   636,000円 |
 * +---------------------------+-----+-------------+
 * | 900万円を超え 1,800万円以下 | 33% | 1,536,000円 |
 * +---------------------------+-----+-------------+
 * | 1,800万円超                | 40% | 2,796,000円 |
 * +---------------------------+-----+-------------+
 *
 * (注)　例えば「課税される所得金額」が700万円の場合には、求める税額は次のようになります。
 * 700万円×0.23-63万6千円＝97万4千円
 *
 * @see http://www.nta.go.jp/taxanswer/shotoku/2260.htm
 */

namespace JTS\IncomeTax;

use \RuntimeException;
use \JTS\IncomeTax\Rule;

class Calculator
{
	/** @var \JTS\IncomeTax\Rule[]  */
	protected $rules = array();

	/**
	 * Return new Rule object.
	 * @return \JTS\IncomeTax\Rule
	 */
	public function rule()
	{
		$rule = new Rule();
		$this->rules[] = $rule;
		return $rule;
	}

	/**
	 * Calculate income tax.
	 * @param int $income
	 * @return bool|int
	 */
	public function getTax($income)
	{
		$income = $this->_roundDown($income);

		foreach ( $this->rules as $rule )
		{
			if ( $rule->isAvailable($income) === true )
			{
				return $rule->getTax($income);
			}
		}

		return false;
	}

	/**
	 * Round down income.
	 * @param int $income
	 * @return int
	 *
	 * When the income amount includes a fraction of less than
	 * one thousand yen, the fraction shall be discarded.
	 */
	protected function _roundDown($income)
	{
		return intval($income / 1000) * 1000;
	}
}
