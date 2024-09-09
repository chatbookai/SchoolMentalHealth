import { useEffect, useRef } from 'react'

// ** MUI Imports
import Button from '@mui/material/Button'
import Grid from '@mui/material/Grid'
import Card from '@mui/material/Card'
import Table from '@mui/material/Table'
import Divider from '@mui/material/Divider'
import TableRow from '@mui/material/TableRow'
import TableHead from '@mui/material/TableHead'
import TableBody from '@mui/material/TableBody'
import Typography from '@mui/material/Typography'
import Box from '@mui/material/Box'
import CardContent from '@mui/material/CardContent'
import { styled, useTheme } from '@mui/material/styles'
import TableContainer from '@mui/material/TableContainer'
import TableCell, { TableCellBaseProps } from '@mui/material/TableCell'

import ReactApexcharts from 'src/@core/components/react-apexcharts'

import { ApexOptions } from 'apexcharts'
import ReactMarkdown from 'react-markdown'
import {isMobile} from 'src/configs/functions'

import Link from 'next/link'

interface Props {
  data: any
  id: string
  backEndApi: string
  printModel: string
}

const MUITableCell = styled(TableCell)<TableCellBaseProps>(({ theme }) => ({
  borderBottom: 0,
  paddingLeft: '0 !important',
  paddingRight: '0 !important',
  paddingTop: `${theme.spacing(1)} !important`,
  paddingBottom: `${theme.spacing(1)} !important`
}))


const SoulAssessmentModelMiddleSchool = ({ data, id, backEndApi, printModel }: Props) => {
  // ** Hook
  const theme = useTheme()

  const isMobileData = isMobile()

  const series = data && data['测评分析'] ? [{name: '心理测评', data: Object.values(data['测评分析']) as number[]}] : [{name: '心理测评', data: []}]

  const options: ApexOptions = {
    chart: {
      parentHeightOffset: 0,
      toolbar: { show: false }
    },
    colors: [theme.palette.primary.main, theme.palette.info.main],
    plotOptions: {
      radar: {
        size: 110,
        polygons: {
          connectorColors: theme.palette.divider,
          strokeColors: [
            theme.palette.divider,
            'transparent',
            'transparent',
            'transparent',
            'transparent',
            'transparent'
          ]
        }
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        gradientToColors: [theme.palette.primary.main, theme.palette.info.main],
        shadeIntensity: 1,
        type: 'vertical',
        opacityFrom: 1,
        opacityTo: 0.9,
        stops: [0, 100]
      }
    },
    labels: data && data['测评分析'] ? Object.keys(data['测评分析']) as string[] : [],
    markers: { size: 0 },
    legend: {
      labels: { colors: theme.palette.text.secondary }
    },
    grid: { show: false },
    xaxis: {
      labels: {
        show: true,
        style: {
          fontSize: '14px',
          colors: [
            theme.palette.text.disabled,
            theme.palette.text.disabled,
            theme.palette.text.disabled,
            theme.palette.text.disabled,
            theme.palette.text.disabled,
            theme.palette.text.disabled
          ]
        }
      }
    },
    yaxis: { show: false }
  }

  useEffect(() => {
    if ( series && series[0] && series[0].data && series[0].data.length > 0 && id && id.length > 32 && data && printModel == "" ) {
      setTimeout(() => {
        window.print()
      }, 3000)
    }
  }, [id, data, series])

  const chartRef = useRef(null);

  useEffect(() => {
    if (chartRef.current) {
      const apexChart = chartRef.current as any;
      if(series && series[0] && series[0].data && series[0].data.length > 0 && apexChart && apexChart.chart) {
        apexChart.chart.render();
      }
    }
  }, [series, options]);

  if (data) {
    return (
      <Card>
        <CardContent>
          <Grid container>
            <Grid item sm={6} xs={12} sx={{ mb: { sm: 0, xs: 4 } }}>
              <Box sx={{ display: 'flex', flexDirection: 'column' }}>
                <Box sx={{ mb: 6, display: 'flex', alignItems: 'center' }}>
                  <Typography
                    variant='h6'
                    sx={{ fontWeight: 600, lineHeight: 'normal', textTransform: 'uppercase' }}
                  >
                    {data['单位名称']}
                  </Typography>
                </Box>
                <div>
                  <div style={{ display: 'flex', flexDirection: 'row', marginBottom: '0.5rem' }}>
                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>学号:</Typography>
                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>{data['用户信息']['学号']}</Typography>
                  </div>
                  <div style={{ display: 'flex', flexDirection: 'row', marginBottom: '0.5rem' }}>
                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>姓名:</Typography>
                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>{data['用户信息']['姓名']}</Typography>
                  </div>
                  <div style={{ display: 'flex', flexDirection: 'row' }}>
                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>班级:</Typography>
                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>{data['用户信息']['班级']}</Typography>
                  </div>
                </div>
              </Box>
            </Grid>
            <Grid item sm={6} xs={12}>
              <Box sx={{ display: 'flex', justifyContent: { xs: 'flex-start', sm: 'flex-end' } }}>
                <Table sx={{ maxWidth: '400px' }}>
                  <TableBody>
                    <TableRow>
                      <MUITableCell colSpan={2}>
                        <Typography variant='h6'>{data['测评名称']}</Typography>
                      </MUITableCell>
                    </TableRow>
                    <TableRow>
                      <MUITableCell>
                        <Typography variant='body2'>测评时间:</Typography>
                      </MUITableCell>
                      <MUITableCell>
                        <Typography variant='body2' sx={{ fontWeight: 600 }}>
                        {data['用户信息']['测评时间']}
                        </Typography>
                      </MUITableCell>
                    </TableRow>
                    <TableRow>
                      <MUITableCell>
                        <Typography variant='body2'>测评用时:</Typography>
                      </MUITableCell>
                      <MUITableCell>
                        <Typography variant='body2' sx={{ fontWeight: 600 }}>
                        {data['用户信息']['使用时间']}
                        </Typography>
                      </MUITableCell>
                    </TableRow>
                    <TableRow>
                      <MUITableCell>
                        <Typography variant='body2'>咨询师:</Typography>
                      </MUITableCell>
                      <MUITableCell>
                        <Typography variant='body2' sx={{ fontWeight: 600 }}>
                        {data['用户信息']['咨询师'] ?? '无'}
                        </Typography>
                      </MUITableCell>
                    </TableRow>
                  </TableBody>
                </Table>
              </Box>
            </Grid>
          </Grid>
        </CardContent>

        <Divider />

        <CardContent>
          <Grid container>
            <Grid item xs={12} sm={12} sx={{ mb: 0 }}>
            <Box sx={{ display: 'flex', flexDirection: 'column' }}>
                <Box sx={{ mb: 4, display: 'flex', alignItems: 'center' }}>
                  <Typography variant='h6' sx={{ fontWeight: 400, lineHeight: 'normal' }} >
                    一、测评说明
                  </Typography>
                </Box>
                <Typography variant='body2' sx={{ marginRight: '1rem', whiteSpace: 'pre-line' }}>{data['测评说明']}</Typography>
              </Box>
            </Grid>
          </Grid>
        </CardContent>

        <Divider />

        <CardContent>
          <Grid container>
            <Grid item xs={12} sm={12} sx={{ mb: 0 }}>
            <Box sx={{ display: 'flex', flexDirection: 'column' }}>
                <Box sx={{ mb: 4, display: 'flex', alignItems: 'center' }}>
                  <Typography variant='h6' sx={{ fontWeight: 400, lineHeight: 'normal' }} >
                    二、评分标准
                  </Typography>
                </Box>
                <Typography variant='body2' sx={{ marginRight: '1rem', whiteSpace: 'pre-line' }}>{data['评分标准']}</Typography>
              </Box>
            </Grid>
          </Grid>
        </CardContent>

        <Divider />

        <CardContent>
          <Grid container>
            <Grid item xs={12} sm={12} sx={{ mb: 0 }}>
            <Box sx={{ display: 'flex', flexDirection: 'column' }}>
                <Box sx={{ mb: 4, display: 'flex', alignItems: 'center' }}>
                  <Typography variant='h6' sx={{ fontWeight: 400, lineHeight: 'normal' }} >
                    三、因子分析
                  </Typography>
                </Box>

                <Grid container spacing={2}>
                  <Grid item xs={12} md={8} sx={{ m: 0, p: 0 }}>
                    <Card>
                      <CardContent sx={{height: '315px'}}>
                        <ReactApexcharts ref={chartRef} type='radar' height={305} series={series} options={options} />
                      </CardContent>
                    </Card>
                  </Grid>
                  <Grid item xs={12} md={4} sx={{ m: 0, p: 0 }}>
                    <Card>
                      <CardContent sx={{height: '315px'}}>
                        <Box sx={{ display: 'flex', flexDirection: 'column' }}>
                            {data && data['测评分析'] && Object.keys(data['测评分析']).map((item: any, index: number)=>{

                              return (
                                <div key={index} style={{ display: 'flex', flexDirection: 'row', marginBottom: '0.45rem' }}>
                                    <Typography variant='body2' sx={{ marginRight: '1rem', whiteSpace: 'nowrap' }}>{item}:</Typography>
                                    <Typography variant='body2' sx={{ marginRight: '1rem' }}>{data['测评分析'][item]}</Typography>
                                </div>
                              )
                            })}
                        </Box>
                      </CardContent>
                    </Card>
                  </Grid>
                </Grid>

                <Grid container spacing={2}>
                  <Grid item xs={12} md={12} sx={{ m: 0, p: 0 }}>
                    <Card>
                      <CardContent>
                        <TableContainer sx={{mb: 3}}>
                            <Table>
                                <TableHead>
                                <TableRow>
                                    <TableCell style={{ whiteSpace: 'nowrap' }}>因子名称</TableCell>
                                    <TableCell >所属因子的项目编号</TableCell>
                                    <TableCell style={{ whiteSpace: 'nowrap' }}>累计得分</TableCell>
                                    <TableCell style={{ whiteSpace: 'nowrap' }}>T分数</TableCell>
                                </TableRow>
                                </TableHead>
                                <TableBody>
                                {data && data['因子分析'] && data['因子分析'].length > 0 && data['因子分析'].map((因子项目: any, IndexCeping: number)=>{

                                    return (
                                    <TableRow key={IndexCeping}>
                                        <TableCell sx={{width: '15%', whiteSpace: 'nowrap'}}>{因子项目.名称}</TableCell>
                                        <TableCell sx={{width: '70%'}}>{data['得分换算表'][因子项目.名称]['项目编号'].join(',')}</TableCell>
                                        <TableCell sx={{width: '15%', whiteSpace: 'nowrap'}}>{data['得分换算表'][因子项目.名称]['累计得分']}</TableCell>
                                        <TableCell sx={{width: '15%', whiteSpace: 'nowrap'}}>{data['得分换算表'][因子项目.名称]['T分数']}</TableCell>
                                    </TableRow>
                                    )
                                })}

                                <TableRow>
                                    <TableCell style={{ whiteSpace: 'nowrap' }} colSpan={4}>
                                        阳性项目数: {data['阳性项目数']}　
                                        阴性项目数: {data['阴性项目数']}　
                                        总累计得分: {data['总累计得分']}　
                                        总因子分数: {data['总因子分数']}　
                                    </TableCell>
                                </TableRow>
                                
                                </TableBody>
                            </Table>
                        </TableContainer>
                      </CardContent>
                    </Card>
                  </Grid>
                </Grid>


                {data && data['因子分析'] && data['因子分析'].length > 0 && data['因子分析'].map((item: any, index: number)=>{

                  return (
                    <TableContainer key={index} sx={{mb: 3}}>
                      <Table>
                        <TableHead>
                          <TableRow>
                            <TableCell colSpan={4}>
                              <Box sx={{ display: 'flex', flexDirection: 'column' }}>
                                <div>
                                  <div style={{ display: 'flex', flexDirection: 'row', marginBottom: '0.5rem' }}>
                                      <Typography sx={{ marginRight: '1rem', whiteSpace: 'nowrap' }}>{index+1} 因子名称:</Typography>
                                      <Typography sx={{ marginRight: '1rem' }}>{item['名称']}</Typography>
                                  </div>
                                  <div style={{ display: 'flex', flexDirection: 'row', marginBottom: '0.5rem' }}>
                                      <Typography variant='body2' sx={{ marginRight: '1rem', whiteSpace: 'nowrap' }}>因子分数:</Typography>
                                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>{item['测评分数']}</Typography>
                                  </div>
                                  <div style={{ display: 'flex', flexDirection: 'row', marginBottom: '0.5rem' }}>
                                      <Typography variant='body2' sx={{ marginRight: '1rem', whiteSpace: 'nowrap' }}>因子解释:</Typography>
                                      <Typography variant='body2' sx={{ marginRight: '1rem' }}>{item['因子解释']}</Typography>
                                  </div>
                                </div>
                              </Box>
                            </TableCell>
                          </TableRow>
                        </TableHead>
                        <TableHead>
                          <TableRow>
                            <TableCell>项目</TableCell>
                            <TableCell style={{ whiteSpace: 'nowrap' }}>选项</TableCell>
                            <TableCell style={{ whiteSpace: 'nowrap' }}>分值</TableCell>
                          </TableRow>
                        </TableHead>
                        <TableBody>
                          {item && item['测评明细'] && item['测评明细'].length > 0 && item['测评明细'].map((Ceping: any, IndexCeping: number)=>{

                            return (
                              <TableRow key={IndexCeping}>
                                <TableCell sx={{width: '70%'}}>{Ceping['测评项目']}</TableCell>
                                <TableCell sx={{width: '15%', whiteSpace: 'nowrap'}}>{Ceping['测评选项']}</TableCell>
                                <TableCell sx={{width: '15%', whiteSpace: 'nowrap'}}>{Ceping['测评分值']}</TableCell>
                              </TableRow>
                            )
                          })}
                          
                        </TableBody>
                      </Table>
                    </TableContainer>
                  )
                })}
              </Box>
            </Grid>
          </Grid>
        </CardContent>

        <Divider />

        <CardContent>
          <Grid container>
            <Grid item xs={12} sm={12} sx={{ mb: 0 }}>
            <Box sx={{ display: 'flex', flexDirection: 'column' }}>
                <Box sx={{ mb: 4, display: 'flex', alignItems: 'center' }}>
                  <Typography variant='h6' sx={{ fontWeight: 400, lineHeight: 'normal' }} >
                    四、人工智能分析
                  </Typography>
                </Box>

                <Grid container spacing={2}>
                  <Grid item xs={12} sx={{ m: 0, p: 0 }}>
                    <Card>
                      <CardContent>
                        <div style={{ color: 'action.active', fontSize: '0.825rem' }}>
                          <ReactMarkdown>{data['DeepSeek'] ? data['DeepSeek'].replace('\n', '  \n') : ''}</ReactMarkdown>
                        </div>
                      </CardContent>
                    </Card>
                  </Grid>
                </Grid>

              </Box>
            </Grid>
          </Grid>
        </CardContent>

        <Divider />

        <CardContent>
          <Typography variant='body2'>
            <strong>说明：</strong> 此报告前三部分由系统自动生成，第四部分到结尾部分由国产AI大模型生成，报告整体用于参考作用，其并不具备任何法律效力。如果需要具有法律效力的报告，请到国家认可的正规机构，并且在具有相关资格从业医师的协助下做出对应的心理测评工作。
          </Typography>
          <Typography variant='body2'>
            <strong>隐私：</strong> 本系统非常注重用户隐私，不会随意搜集、滥用和外泄用户信息。系统提交给国产大模型的数据，只涉及了测评数据，没有提交用户任何身份信息或是隐私信息给到大模型，请放心使用。
          </Typography>
          {printModel && printModel == "print" && isMobileData == false && (
            <Grid container justifyContent="flex-end">
              <Button
                target='_blank'
                sx={{ mb: 3.5 }}
                component={Link}
                color='primary'
                size="small"
                variant='outlined'
                href={`/print/middleschool/${id}____${backEndApi.replace('.php', '').replace('apps/apps_', '')}`}
              >
                {'打印'}
              </Button>
            </Grid>
          )}
        </CardContent>

      </Card>
    )
  } else {
    return null
  }
}

export default SoulAssessmentModelMiddleSchool
