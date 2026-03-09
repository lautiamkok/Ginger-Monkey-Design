import isEmpty from '@/utils/is-empty'

export default async (path, options) => {
  // Fetch the data.
  const response = await fetch(path, options)
  const json = await response.json()

  // Set the data: null or json.
  const data = isEmpty(json) ? null : json
  data.statusCode = response.status

  return { data }
}
